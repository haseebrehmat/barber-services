<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Recipient;
use App\Models\Admin\Tag;
use Illuminate\Http\Request;
use App\Models\Admin\Subscriber;
use App\Models\LandingPageContact;
use App\Models\ExcelContact;


class RecipientController extends Controller
{

    public function index()
    {

        // $subscribers = Subscriber::where('subs_active', 1)->get();
        // $customers = LandingPageContact::all();
        // $excel_customers = ExcelContact::all();

        // foreach ($subscribers as  $subscriber) {
        //     $found=Recipient::where('email',$subscriber->subs_email)->count();
        //     if($found==0){
        //         $to_save=new Recipient();
        //         $to_save->email=$subscriber->subs_email;
        //         $to_save->name=strstr($subscriber->subs_email, '@',true);
        //         $to_save->source='subsribers';
        //         $to_save->save();
        //     }
        // }

        // foreach ($customers as  $customer) {
        //     $found=Recipient::where('email',$customer->email)->count();
        //     if($found==0){
        //         $to_save=new Recipient();
        //         $to_save->email=$customer->email;
        //         $to_save->name=$customer->name;
        //         $to_save->source='customers';
        //         $to_save->save();
        //     }
        // }

        // foreach ($excel_customers as  $excel_customer) {
        //     $found=Recipient::where('email',$excel_customer->email)->count();
        //     if($found==0){
        //         $to_save=new Recipient();
        //         $to_save->email=$excel_customer->email;
        //         $to_save->name=$excel_customer->name;
        //         $to_save->source='excel_contacts';
        //         $to_save->save();
        //     }
        // }

        $data = Recipient::with('tags')->get();

        return view('admin.recipients.index', compact('data'));
    }

    public function create()
    {
        $tags = Tag::pluck('name', 'id')->toArray();

        return view('admin.recipients.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:500',
            'email' => 'required|max:500|unique:recipients,email',
            'tag_ids' => 'required'
        ]);

        $recipient = Recipient::create($data);

        $recipient->tags()->attach($data['tag_ids']);

        return redirect()->route('admin.recipient.index')->with('success', 'Recipient is created successfully');
    }

    public function edit(Recipient $recipient)
    {
        $tags = Tag::pluck('name', 'id')->toArray();

        return view('admin.recipients.edit')->with('data', $recipient)->with('tags', $tags);
    }

    public function update(Request $request, Recipient $recipient)
    {
        $data = $request->validate([
            'name' => 'required|max:500',
            'email' => 'required|max:500|unique:recipients,email,' . $recipient->id,
            'tag_ids' => 'required'
        ]);

        $recipient->update($data);

        $recipient->tags()->sync($data['tag_ids']);

        return redirect()->route('admin.recipient.index')->with('success', 'Recipient is updated successfully');
    }

    public function destroy(Recipient $recipient)
    {
        $recipient->tags()->detach();
        $recipient->campaigns()->detach();

        $recipient->delete();

        return redirect()->route('admin.recipient.index')->with('success', 'Recipient is deleted successfully');
    }
}
