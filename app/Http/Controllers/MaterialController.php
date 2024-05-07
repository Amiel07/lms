<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class MaterialController extends Controller
{
    // Navigate to new
    public function new($courseId,$moduleId){
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);
        if ($course->author_id != auth()->user()->id){
            return abort(404);
        }
        if (View::exists('teacher.materials.new')){
            return view('teacher.materials.new', ['course' => $course, 'module' => $module]);
        }
        else{
            return abort(404);
        }
    }

    public function save_new(Request $request, $courseId, $moduleId){
        $request->merge(['hidden' => 0]);
        $request->merge(['module_id' => $moduleId]);
        // $request->merge(['link' => $request['link']]);
        $validated = $request->validate([
            "name" => 'required',
            "type" => 'required',
            "resource" => 'max:2000000',
            // "link" => '',
            "module_id" => 'required',
            "hidden" => 'required',
        ]);
        if ($request->hasFile('resource')) {
            $file = $request->file('resource');
            $fileName = $courseId . '_' . $moduleId . '_' . $file->getClientOriginalName();
            $validated['resource'] = $fileName;
            $file->move(public_path('files'), $fileName);
        }
        
        Material::create($validated);
        $module = Module::findOrFail($moduleId);
        $data = ["message" => "You have uploaded a material for module " . '"' . $module->name . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        $course = Course::find($courseId);
        $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            ->where('courses.author_id', auth()->user()->id)
            ->select('modules.*')
            ->get();
        return redirect(route('teacher.courses.modules', ['course' => $course, 'modules' => $modules]))->with('success', 'Successfully saved new material!');
    }

    public function delete($courseId, $moduleId, $materialId){
        $materialTarget = Material::findOrFail($materialId);
        if ($materialTarget){
            if ($materialTarget->type === 1){
                $file = public_path('files/'. $materialTarget->resource);
                unlink($file);
            }
            $materialTarget->delete();
            // $courses = Course::where('author_id', auth()->user()->id)->get();
            // $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            //     ->where('courses.author_id', auth()->user()->id)
            //     ->select('modules.*')
            //     ->get();
            // $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
            $data = ["message" => "You have removed a material for module " . '"' . $materialTarget->name . '"'];
            $user = auth()->user();
            Notification::send([$user], new CustomNotification($data));
            return back()->with('success', 'Successfully deleted the material!');
        }
        else{
            // $modules = Module::where('course_id', $courseId)->get();
            // $courses = Course::where('author_id', auth()->user()->id)->get();
            // $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
            //     ->where('courses.author_id', auth()->user()->id)
            //     ->select('modules.*')
            //     ->get();
            // $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
            return back()->with('success', 'Failed to delete the material!');
        }
    }


    public function edit($course_id, $module_id, $material_id){
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $material = Material::find($material_id);

        return view('teacher.materials.edit', ['course' => $course, 'module' => $module, 'material' => $material]);
    }

    public function update(Request $request){
        $course = Course::find($request->course_id);
        $material = Material::find($request->material_id);
        // dd($course);
        // delete material first
        if ($material->type  === 1){
            $file = public_path('files/'. $material->resource);
            unlink($file);
        }


        $validated = $request->validate([
            "name" => 'required',
            "type" => 'required',
            "resource" => 'max:2000000'
        ]);
        if ($request->hasFile('resource')) {
            $file = $request->file('resource');
            $fileName = $request->course_id . '_' . $request->module_id . '_' . $file->getClientOriginalName();
            $validated['resource'] = $fileName;
            $file->move(public_path('files'), $fileName);
        }

        $material->name = $validated['name'];
        $material->resource = $validated['resource'];
        $material->type = $validated['type'];
        $material->save();

        return redirect(route('teacher.courses.modules', ['course' => $course->id]))->with('success', 'Material successfully updated.');
    }
}
