<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Group;
use App\Models\Admin\GroupContact;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    public function index()
    {
        return view('admin.group.index')->with('groups', Group::withCount('contacts')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|max:255', 'detail' => 'sometimes']);

        Group::create($data);

        return back()->with('success', 'Group added successfully!');
    }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate(['name' => 'required|max:255', 'detail' => 'sometimes']);

        $group->update($data);

        return back()->with('success', 'Group updated successfully!');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return back()->with('success', 'Group and its contacts deleted successfully!');
    }

        public function contacts(Request $request)
        {
            $groups = Group::select('id', 'name')->withCount('contacts')->get();
            
            $contacts=null;
            $active_group_id=null;
            if(count($groups)){
                $active_group_id = $request->has('group_id')
                ? $request->get('group_id')
                : $groups->first()->value('id');
                $contacts = GroupContact::where('group_id', $active_group_id)
                    ->orderByDesc('updated_at')->paginate(10);
            }
            
            return view('admin.group.contacts.index', compact('groups', 'contacts', 'active_group_id'));
        }

    public function import_contacts(Request $request)
    {
        session(['gid' => $request->get('group_id')]);
        try {
            // $request->validate([
            //     'file' => 'required|mimes:xlsx,xls',
            //     'group_id' => 'required',
            // ]);

            $file = $request->file('file');
            $data = Excel::toArray(null, $file)[0];

            if (!empty($data)) {
                $this->validateHeader($data[0]);
                unset($data[0]); // Remove the header row

                $validatedData = $this->filterValidData($data, $request);

                if (count($validatedData) > 0) {
                    $this->saveValidData($validatedData, $request);
                    return back()->with('success', 'Group Contacts Added successfully!');
                } else {
                    return back()->with('error', 'No valid data found in the file.');
                }
            } else {
                return back()->with('error', 'The file is empty or invalid.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong due to ' . $e->getMessage());
        }
    }

    private function validateHeader(array $header)
    {
        if (count($header) < 3 || $header[0] !== 'Name' || $header[1] !== 'Email' || $header[2] !== 'Number') {
            throw new \Exception('Invalid file format. Please make sure the file has the correct headers.');
        }
    }

    private function filterValidData(array $data, Request $request)
    {
        $validatedData = [];
        foreach ($data as $row) {
            if (count($row) >= 3 && !empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                $validatedData[] = $row;
            }
        }
        return $validatedData;
    }

    private function saveValidData(array $data, Request $request)
    {
        foreach ($data as $row) {
            $contact = new GroupContact;
            $contact->group_id = $request->get('group_id', null);
            $contact->name = $row[0];
            $contact->email = $row[1];
            $contact->phone = $row[2];
            $contact->save();
        }
    }

    public function update_contact(Request $request, GroupContact $contact)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:25',
            'name' => 'required|max:224',
        ]);

        $contact->update($data);

        session(['gid' => $contact->group_id]);

        return back()->with('success', 'Group Contact updated successfully!');
    }

    public function delete_contact(GroupContact $contact)
    {
        session(['gid' => $contact->group_id]);

        $contact->delete();

        return back()->with('success', 'Group Contact deleted successfully');
    }

    public function store_contact(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:25',
            'name' => 'required|max:224',
        ]);

        session(['gid' => $data['group_id']]);

        GroupContact::create($data);

        return back()->with('success', 'Group Contact added successfully!');
    }
}
