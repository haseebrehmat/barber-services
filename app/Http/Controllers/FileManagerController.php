<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['takeSignature', 'saveSignature']]);
    }

    public function index(Request $request)
    {
        $files = DB::table('file_manager')->orderBy('updated_at', 'ASC')->get();
        return view('admin.file_manager.index', ['files' => $files]);
    }

    public function upload(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'file.*' => 'required|file|max:50000'
            ]);

            $files = $request->file('file');

            $data = [];

            foreach ($files as $file) {

                $original = $file->getClientOriginalName();
                $name = explode('.', $original)[0];
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $hashname = $name . '_' . time() . '.' . $ext;
                $file->storeAs('public', $hashname);

                $data[] = ['filename' => $original, 'size' => $size, 'hashname' => $hashname, 'extension' => $ext];
            }

            DB::table('file_manager')->insert($data);
            DB::commit();
            return redirect()->back()->with('success', 'Files uploaded successfully!');

        } catch (\Exception $th) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Something gone wrong while uploading files');
        }
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder' => 'required|string|regex:/^[a-zA-Z0-9_]+$/|max:10'
        ]);

        $folder = $request->input('folder');
        Storage::makeDirectory('public/' . $folder);

        return redirect()->back()->with('success', 'Folder created successfully!');
    }

    public function download($name)
    {
        return Storage::download('public/' . $name);
    }

    public function remove($id, $name)
    {
        try {
            DB::table('file_manager')->where('id', $id)->delete();
            Storage::delete('public/' . $name);
            return redirect()->back()->with('success', 'Folder removed successfully!');

        } catch (\Exception $th) {
            dd($th);
            return redirect()->back()->with('error', 'File is not removed due to some error!');
        }
    }

    public function signaturePad()
    {
        return view('admin.file_manager.pad');
    }

    public function takeSignature($id)
    {
        $file = DB::table('file_manager')->find($id);
        return view('admin.file_manager.take_signature', ['file' => $file]);
    }

    public function saveSignature(Request $request, $id)
    {
        try {
            if ($request->signature) {

                $folderPath = "public/storage/";
                $base64Image = explode(";base64,", $request->signature);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $filname = uniqid() . '.' . $imageType;
                $file = $folderPath . $filname;
                file_put_contents($file, $image_base64);

                $exists = DB::table('file_manager')->where('id', $id)->first();
                
                if ($exists && $exists->signature) {
                    Storage::delete('public/' . $exists->signature);
                }

                DB::table('file_manager')->where('id', $id)->update(['signature' => $filname]);
            }
            return redirect()->back()->with('success', 'Signature is taken successfully!');

        } catch (\Exception $th) {

            return redirect()->back()->with('error', 'Please try again! Signature is not sved due to this error! ' . $th->getMessage());
        }
    }
}
