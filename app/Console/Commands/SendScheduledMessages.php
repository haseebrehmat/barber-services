<?php

namespace App\Console\Commands;

use App\Models\Admin\ScheduleMessages;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use App\Models\Customer;
use App\Models\LandingPageContact;
use Twilio\Rest\Client;

class SendScheduledMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:schedule_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Schedule Messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDateTime = Carbon::now();

        $records = ScheduleMessages::where('scheduled_at', '<=', $currentDateTime)
            ->where('status', 'pending')
            ->get();

        $this->info($records);

        foreach ($records as $record) {

            try {
                $customersIds = explode(",", $record['user_ids']);
                $message1 = $record['msg'];

                if ($record['module'] == 'registered_customers') {
                    $count1 = 0;
                    try {

                        $customers = Customer::whereIn('id', $customersIds)->get();

                        foreach ($customers as $row) {

                            $row->last_message = $message1 . ' ' . '(SMS)';
                            $row->save();

                            $account_sid = env('TWILIO_ACCOUNT_SID');
                            $auth_token = env('TWILIO_AUTH_TOKEN');
                            $twilio_number = env('TWILIO_PHONE_NUMBER');

                            $recipient_number = $row->customer_phone;
                            $message_body = $message1;

                            $twilio = new Client($account_sid, $auth_token);

                            $twilio->messages->create(
                                $recipient_number,
                                array(
                                    'from' => $twilio_number,
                                    'body' => $message_body
                                )
                            );

                            $count1++;
                        }

                    } catch (\Exception $e) {
                        $this->error('Message is not sent due to ' . $e->getMessage());
                        continue;
                    }

                    if ($count1 > 0) {
                        DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count1)]);
                    }
                }

                if ($record['module'] == 'landing_page_contacts') {
                    $count2 = 0;
                    try {
                        $customers = LandingPageContact::whereIn('id', $customersIds)->get();

                        foreach ($customers as $row) {

                            $row->last_message = $message1 . ' ' . '(SMS)';
                            $row->save();


                            $account_sid = env('TWILIO_ACCOUNT_SID');
                            $auth_token = env('TWILIO_AUTH_TOKEN');
                            $twilio_number = env('TWILIO_PHONE_NUMBER');

                            $recipient_number = $row->phone;
                            $message_body = $message1;

                            $twilio = new Client($account_sid, $auth_token);

                            $twilio->messages->create(
                                $recipient_number,
                                array(
                                    'from' => $twilio_number,
                                    'body' => $message_body // message body
                                )
                            );

                            $count2++;
                        }
                    } catch (\Throwable $th) {
                        $this->error('Message is not sent due to ' . $e->getMessage());
                        continue;
                    }

                    if ($count2 > 0) {
                        DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count2)]);
                    }
                }

                $record->update(['status' => 'sent']);
                $this->info('Scheduled messages sent successfully.');

            } catch (\Exception $th) {

                $record->update(['status' => 'failed']);
                $this->error('Messages is not sent due to ' . $e->getMessage());
            }
        }

        return 0;
    }
}
