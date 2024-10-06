<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Group;
use DB;
use App\Mail\SendToRecipients;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $subject;
    protected $message;
    protected $groups;
    protected $ref_template;
    
    public function __construct($subject, $message, $groups, $ref_template)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->groups = $groups;
        $this->ref_template = $ref_template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = $this->subject;
        $message = $this->message;
        $groups = $this->groups;
        $ref_template = $this->ref_template;

        $errors = [];
        $total = 0;
        $successful = 0;
        $failed = 0;
        $fixed_groups = ['recipients', 'subscribers', 'landing_page', 'external_data'];


        foreach ($groups as $group) {
            try {
                if ($group == 'recipients') {
                    $emails = DB::table('recipients')->get();

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);
                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $e) {
                                $errors[] = "Error sending email to recipient {$row->email}: " . $e->getMessage();
                                $failed++;
                            }
                        }
                    }
                }
                if ($group == 'subscribers') {
                    $emails = DB::table('subscribers')->get();

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_email]]', $row->subs_email, $message);
                                Mail::to($row->subs_email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $e) {
                                $errors[] = "Error sending email to recipient {$row->subs_email}: " . $e->getMessage();
                                $failed++;
                            }
                        }
                    }
                }
                if ($group == 'landing_page') {
                    if (session()->has('landing_page_customer_ids')) {
                        $customer_ids = session()->get('landing_page_customer_ids', []);
                        $emails = DB::table('landing_page_contacts')->whereIn('id', $customer_ids)->get();
                    } else {
                        $emails = DB::table('landing_page_contacts')->get();
                    }

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);
                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $e) {
                                $errors[] = "Error sending email to recipient {$row->email}: " . $e->getMessage();
                                $failed++;
                            }
                        }
                    }
                }
                if ($group == 'external_data') {
                    $emails = DB::table('excel_contacts')->get();

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);
                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $e) {
                                $errors[] = "Error sending email to recipient {$row->email}: " . $e->getMessage();
                                $failed++;
                            }
                        }
                    }
                }
                if (!in_array($group, $fixed_groups)) {
                    $emails = DB::table('group_contacts')->where('group_id', $group)->get();

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);
                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $e) {
                                $errors[] = "Error sending email to recipient {$row->email}: " . $e->getMessage();
                                $failed++;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $errors[] = "Error processing group {$group}: " . $e->getMessage();
            }
        }
        $total = $successful + $failed;
        try {
            $custom_groups = Group::whereIn('id', $groups)->pluck('name')->toArray();

            $default_groups = array_filter($groups, function ($value) use ($fixed_groups) {
                return in_array($value, $fixed_groups);
            });

            $groups = array_merge($default_groups, $custom_groups);

            DB::table('sent_emails')->insert([
                'subject' => $subject,
                'message' => $message,
                'groups' => implode(",", $groups),
                'ref_template_id' => $ref_template,
                'total_sent' => $total,
                'successful' => $successful,
                'failed' => $failed,
                'module' => 'direct'
            ]);


        } catch (\Exception $e) {
            $errors[] = "Error saving record in database: " . $e->getMessage();
        }

        print_r($errors);
    }
}
