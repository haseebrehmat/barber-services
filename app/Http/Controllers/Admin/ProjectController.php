<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Models\Admin\Admin;
use App\Models\Admin\ProjectPhoto;
use App\Models\Admin\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class ProjectController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin');
    }

    public function index()
    {
        $project = Project::all();
        $admin_data = Admin::where('id',session('id'))->first();

        return view('admin.project.index', compact('project'));
    }

    public function create()
    {
        $employees = Admin::where('role_id', '!=', 1)->get();

        return view('admin.project.create', compact('employees'));
    }

    public function store(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $project = new Project();
        $data = $request->only($project->getFillable());

        $request->validate([
            'project_name' => 'required|unique:projects',
            'emp_id' => 'required',
            'project_slug' => 'unique:projects',
            'project_featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if(empty($data['project_slug'])) {
            $data['project_slug'] = Str::slug($request->project_name);
        }

        $statement = DB::select("SHOW TABLE STATUS LIKE 'projects'");
        $ai_id = $statement[0]->Auto_increment;
        $ext = $request->file('project_featured_photo')->extension();
        $final_name = time().'.'.$ext;
        $request->file('project_featured_photo')->move(public_path('uploads/'), $final_name);
        $data['project_featured_photo'] = $final_name;


        $project->fill($data)->save();
        return redirect()->route('admin.project.index')->with('success', 'Project is added successfully!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $employees = Admin::where('role_id', '!=', 1)->get();
        return view('admin.project.edit', compact('project','employees'));
    }

    public function update(Request $request, $id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $project = Project::findOrFail($id);
        $data = $request->only($project->getFillable());

        if($request->hasFile('project_featured_photo')) {
            $request->validate([
                'project_name'   =>  [
                    'required',
                    Rule::unique('projects')->ignore($id),
                ],
                'project_slug'   =>  [
                    Rule::unique('projects')->ignore($id),
                ],
                'project_featured_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'emp_id' => 'required'
            ]);
            // unlink(public_path('uploads/'.$project->project_featured_photo));
            $ext = $request->file('project_featured_photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('project_featured_photo')->move(public_path('uploads/'), $final_name);
            $data['project_featured_photo'] = $final_name;
        } else {
            $request->validate([
                'project_name'   =>  [
                    'required',
                    Rule::unique('projects')->ignore($id),
                ],
                'project_slug'   =>  [
                    Rule::unique('projects')->ignore($id),
                ]
            ]);
            $data['project_featured_photo'] = $project->project_featured_photo;
        }

        $project->fill($data)->save();
        return redirect()->route('admin.project.index')->with('success', 'Project is updated successfully!');
    }

    public function destroy($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $project = Project::findOrFail($id);
        // unlink(public_path('uploads/'.$project->project_featured_photo));
        $project->delete();

        $project_photo = ProjectPhoto::where('project_id',$id)->get();
        foreach($project_photo as $row)
        {
            // unlink(public_path('uploads/'.$row->project_photo));
            DB::table('project_photos')->where('project_id',$row->project_id)->delete();
        }

        return Redirect()->back()->with('success', 'Project is deleted successfully!');
    }

    public function gallerysection($id)
    {
        $project_photo = ProjectPhoto::where('project_id',$id)->get();
        $project_id = $id;
        return view('admin.project.gallery', compact('project_photo','project_id'));
    }

    public function gallerystore(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $project_photo = new ProjectPhoto();
        $data = $request->only($project_photo->getFillable());

        $request->validate([
            'project_photo' => 'required|mimes:pdf|max:2048',
        ], [
            'project_photo.required' => 'Please upload a PDF file.',
            'project_photo.mimes' => 'Please upload a PDF file only.',
            'project_photo.max' => 'The PDF file size should not exceed 2MB (2048 KB).',
        ]);
        $statement = DB::select("SHOW TABLE STATUS LIKE 'project_photos'");
        $ai_id = $statement[0]->Auto_increment;
        $ext = $request->file('project_photo')->extension();
        $final_name = time().'.'.$ext;
        $request->file('project_photo')->move(public_path('uploads/'), $final_name);
        $data['project_photo'] = $final_name;
        $data['project_id'] = $request->project_id;
        $project_photo->fill($data)->save();
        return redirect()->back()->with('success', 'Project PDF is added successfully!');
    }

    public function gallerydelete($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $project_photo = ProjectPhoto::findOrFail($id);
        // unlink(public_path('uploads/'.$project_photo->project_photo));
        $project_photo->delete();
        return Redirect()->back()->with('success', 'Project Photo is deleted successfully!');
    }
    public function project_tasks($id)
    {
        $tasks = ProjectTask::where('project_id', $id)->orderBy('updated_at', 'DESC')->get();

        $project = DB::table('projects')->where('id', $id)->first();

        return view('admin.project.tasks', compact('tasks', 'project'));
    }

    public function store_project_task(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data = $request->validate([
            'detail' => 'required',
            'date' => 'required',
            'status' => 'required|in:pending,canceled,completed',
            'project_id' => 'required'
        ]);

        $data['created_by'] = session()->get('name');

        ProjectTask::create($data);

        return redirect()->back()->with('success', 'Project task is added successfully!');
    }

    public function delete_project_task(ProjectTask $projectTask)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $projectTask->delete();

        return Redirect()->back()->with('success', 'Project task is deleted successfully!');
    }

    public function update_project_task_status(Request $request, ProjectTask $projectTask)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data = $request->validate([
            'status' => 'required|in:pending,canceled,completed',
        ]);

        $projectTask->update($data);

        return back()->with('success', 'Project task status is changed successfully!');
    }
}
