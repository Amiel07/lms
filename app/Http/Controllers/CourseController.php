<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class CourseController extends Controller
{
    
    public function new(){
        if (View::exists('teacher.courses.new')){
            return view('teacher.courses.new');
        }
        else{
            return abort(404);
        }
    }

    public function save_new(Request $request){
        $request->merge(['hidden' => 0]);
        $request->merge(['author_id' => auth()->user()->id]);
        $request->merge(['meeting_link' => $request['meeting_link']]);

        if ($request->has('power_ups')){
            $request->merge(['power_ups' => 1]);
        }else{
            $request->merge(['power_ups' => 0]);
        }

        $validated = $request->validate([
            "course_code" => 'required',
            "name" => 'required',
            "description" => 'required',
            "meeting_link" => 'required',
            "power_ups" => 'required',
            "author_id" => 'required',
            "invite_code" => 'required',
            "hidden" => 'required',
        ]);

        Course::create($validated);
        
        $data = ["message" => "You have created a new course " . '"' . $validated['name'] . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        $data = Course::all();
        return redirect(route('teacher.courses.all', ['courses' => $data]))->with('course_save', 'Course Successfully Added.');
    }

    public function delete($courseId){
        $courseTarget = Course::findOrFail($courseId);
        if ($courseTarget){
            $courseTarget->delete();


            $data = ["message" => "You have deleted a course " . '"' . $courseTarget->name . '"'];
            $user = auth()->user();
            Notification::send([$user], new CustomNotification($data));
            $data = Course::where('author_id', auth()->user()->id)->get();
            return redirect(route('teacher.courses.all', ['courses' => $data]))->with('success', 'Course successfully deleted.');
        }
        else{
            $data = Course::where('author_id', auth()->user()->id)->get();
            return redirect(route('teacher.courses.all', ['courses' => $data]))->with('error', 'Course deletion failed.');
        }
    }

    public function edit($course_id){
        $course = Course::findOrFail($course_id);
        return view('teacher.courses.edit', ['course' => $course]);
    }
    
    public function update(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);

        // Update the course properties with the new values from the form
        $course->course_code = $request->input('course_code');
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->meeting_link = $request->input('meeting_link');
        $course->invite_code = $request->input('invite_code');
        
        // Check if power_ups checkbox is checked
        $course->power_ups = $request->has('power_ups') ? 1 : 0;

        // Save the updated course
        $course->save();


        $data = ["message" => "You have updated the course " . '"' . $course->name . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));
        // Redirect to the course list page with a success messages
        $data = Course::where('author_id', auth()->user()->id);
        return redirect()->route('teacher.courses.all', ['courses' => $data])->with('success', 'Course Successfully Updated.');
    }

    public function archive($course_id){
        $course = Course::find($course_id);
        $course->hidden = !$course->hidden;
        $course->save();
        return back()->with('success', 'Successfully archived the course.');
    }
}
