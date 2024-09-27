<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\Project;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Mail\SendProjectEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index() {
        return view('admin.project.index');
    }

    public function getData(Request $request){
        try {
            $items = Project::with('staff')->get();
            return view('admin.project.table', compact('items'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function getDeletedData(Request $request){
        try {
            $items = Project::onlyTrashed()->with('staff')->get();
            return view('admin.project.recycle_table', compact('items'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function create() {
        $staffs = Staff::all();
        return view('admin.project.create', compact('staffs'));
    }
    
    public function edit($id) {
        $staffs = Staff::all();
        $project = Project::find($id);
        return view('admin.project.edit', compact('project', 'staffs'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'assign_staff_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $data = $request->except('files');
            $data['file'] = json_encode(Cache::get('files'));
            Project::create($data);
            $mailData = [
                'title' => 'Mail from google.com',
                'body' => 'This is for testing email using smtp.'
            ];
            
            Mail::to('admin@gmail.com')->queue(new SendProjectEmail($mailData));
        
            DB::commit();
            return response()->json(['message' => 'Project created succesfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'assign_staff_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $data = $request->except('files', '_method', '_token');
            $files = Cache::get('files');
            if (!empty($files)) {
                $data['file'] = json_encode($files);
            }
            Project::where('id', $id)->update($data);
            $mailData = [
                'title' => 'Mail from google.com',
                'body' => 'This is for testing email using smtp.'
            ];
            
            Mail::to('admin@gmail.com')->queue(new SendProjectEmail($mailData));
            DB::commit();
            return response()->json(['message' => 'Project updated succesfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadFiles(Request $request)
    {
        $request->validate([
            'attachment.*' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);
        $images=array();
        if ($request->hasFile('attachment')) {
            foreach($request->attachment as $key => $image)
            {
                $imageName = time().rand(1,99).'.'.$image->extension();  
                $image->move(public_path('images'), $imageName);
                $images[] = $imageName;
            }
            
        }
        Cache::put('files', $images);
        return response()->json(['success' => $images]);
    }

    public function destroy($id)
    {
        try {
            $data = Project::findOrFail($id);
            $data->delete();
            return response()->json(['success' => 'Data deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function restoreDeleteData(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            $data = Project::onlyTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['success' => 'Data restored successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}