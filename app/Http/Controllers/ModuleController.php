<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Module;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomNotification;

class ModuleController extends Controller
{
    public function modules($courseId){

        $course = Course::findOrFail($courseId);
        if ($course->author_id != auth()->user()->id){
            return abort(404);
        }
        $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            ->where('courses.author_id', auth()->user()->id)
            ->select('modules.*')
            ->get();
        
        // dd($modules);
        if (View::exists('teacher.coursemodules.all')){
            return view('teacher.coursemodules.all', ['modules' => $modules, 'course' => $course]);
        }
        else{
            return abort(404);
        }
    }

    public function new($courseId){
        $course = Course::findOrFail($courseId);
        if ($course->author_id != auth()->user()->id){
            return abort(404);
        }
        if (View::exists('teacher.coursemodules.new')){
            return view('teacher.coursemodules.new', [ 'course' => $course]);
        }
        else{
            return abort(404);
        }
    }

    public function save_new(Request $request, $courseId){
        $request->merge(['hidden' => 0]);
        $request->merge(['course_id' => $courseId]);

        $request->merge(['is_task' => ($request->has('is_task')) ? 1 : 0]);

        $validated = $request->validate([
            "name" => 'required',
            "description" => 'required',
            "is_task" => 'required',
            "course_id" => 'required',
            "hidden" => 'required',
        ]);
        Module::create($validated);

        $data = ["message" => "You have created a new module " . '"' . $validated["name"] . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        $course = Course::find($courseId);
        $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            ->where('courses.author_id', auth()->user()->id)
            ->select('modules.*')
            ->get();
        return redirect(route('teacher.courses.modules', ['course' => $course, 'modules' => $modules]))->with('success', 'Successfully saved new module!');
    }

    public function delete($courseId, $moduleId){
        // dd($moduleId);
        $moduleTarget = Module::findOrFail($moduleId);
        if ($moduleTarget){
            $moduleTarget->delete();
            $data = ["message" => "You have deleted the module " . '"' . $moduleTarget->name . '"'];
            $user = auth()->user();
            Notification::send([$user], new CustomNotification($data));

            return back()->with('success', 'Successfully deleted the module!');
        }
        else{
            return back()->with('success', 'Failed to delete the module!');
        }
    }

    public function edit($course_id, $module_id){
        $course = Course::findOrFail($course_id);
        $module = Module::findOrFail($module_id);
        return view('teacher.coursemodules.edit', ['course' => $course, 'module' => $module]);
    }

    public function update(Request $request, $course_id, $module_id)
    {
        $request->merge(['is_task' => ($request->has('is_task')) ? 1 : 0]);
        $validated = $request->validate([
            "name" => 'required',
            "description" => 'required',
            "is_task" => 'required',
        ]);

        // Find the module by its ID
        $module = Module::findOrFail($module_id);

        // Update the module with the new values from the form
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->is_task = $request->input('is_task');
        $module->save();


        $data = ["message" => "You have updated the module " . '"' . $module->name . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        $course = Course::findOrFail($course_id);
        $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            ->where('courses.author_id', auth()->user()->id)
            ->select('modules.*')
            ->get();
        // Redirect back or wherever appropriate
        return redirect()->route('teacher.courses.modules', ['modules' => $modules, 'course' => $course])->with('success', 'Module Successfully Updated.');
    }


    public function uploadTaskMaterial(Request $request){
        $course = Course::find($request->course_id);
        $module = Module::find($request->module_id);
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,pdf|max:5120', // Example validation rules
        ]);
        

        if ($request->hasFile('uploaded_files')) {

            foreach ($request->file('uploaded_files') as $file) {
                $fileName = auth()->user()->id . '_' . $course->id . '_' . $module->id . '_' . $file->getClientOriginalName();
                $file->storeAs('files/student_uploads', $fileName, 'publichtml');
            }
            
            // place file into public/files/student_uploads/
            // filename shoudl be $course->id.'_'.$module->id.'_'.$file->getClientOriginalName();

            return back()->with('success', 'Files successfully uploaded.');
        }

        return back()->with('error', 'Something went wrong while uploading.');
    }

    public function clearTaskMaterial(Request $request){
        
        $directory = public_path('files/student_uploads');
        
        
        $pattern = auth()->user()->id . '_' . $request->course_id . '_' . $request->module_id . '_*';
        
        
        $files = glob($directory . '/' . $pattern);
        
        foreach ($files as $file) {
            
            if (is_file($file)) {
                unlink($file);
            }
        }

        return response()->json(['message' => 'Files deleted successfully']);
    }


    public function viewSubmissions($module_id){
        $module = Module::find($module_id);
        $course = Course::find($module->course_id);
        $enrolled_students = User::select('users.*')
            ->join('enrollments', 'users.reference_id', '=', 'enrollments.student_id')
            ->where('enrollments.course_id', $course->id)
            ->where('users.type', 2)
            ->get();
            return view('teacher.courses.all-submissions', ['course' => $course, 'module' => $module, 'enrollees' => $enrolled_students  ]);
    }

    public function viewSubmitted(Request $request){
        $files = getSubmittedFiles($request->student_id, $request->course_id, $request->module_id);

        return view('teacher.courses.submitted-files', ['files' => $files]);
    }
}
