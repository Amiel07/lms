<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\CourseAnnouncement;
use App\Models\CourseComment;
use App\Models\ModuleComment;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class CourseAnnouncementController extends Controller
{
    public function new($course_id){
        if (View::exists('teacher.courses.new-announcement')){
            $course = Course::find($course_id);
            return view('teacher.courses.new-announcement', ['course' => $course]);
        }
        else{
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validate incoming request data
        $validatedData = $request->validate([
            'announcement' => 'required|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Create a new CourseAnnouncement instance
        $announcement = new CourseAnnouncement();
        $announcement->announcement = $validatedData['announcement'];
        $announcement->user_id = auth()->user()->id;
        $announcement->course_id = $validatedData['course_id'];
        
        // Save the announcement
        $announcement->save();
        $course = Course::findOrFail($request['course_id']);
        $data = ["message" => "You have posted an announcement for course " . '"' . $course->name . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        // Return a response indicating success
        return back()->with('success', 'Announcement posted successfully');
    }


    public function store_comment(Request $request)
    {
        // dd($request);
        // Validate incoming request data
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'announcement_id' => 'required|exists:course_announcements,id',
        ]);
        

        // Create a new CourseAnnouncement instance
        $comment = new CourseComment();
        $comment->comment = $validatedData['comment'];
        $comment->user_id = auth()->user()->id;
        $comment->announcement_id = $validatedData['announcement_id'];
        
        // Save the announcement
        $comment->save();
        
        $announcement = CourseAnnouncement::find($validatedData['announcement_id']);
        $course = Course::find($announcement->course_id);
        $teacher = User::find($announcement->user_id);
        $student_name = auth()->user()->lastname . ', ' . auth()->user()->firstname . ' ' . auth()->user()->middlename;
        $data = ["message" => $student_name ." commented on your announcement for course " . '"' . $course->name . '"'];
        Notification::send([$teacher], new CustomNotification($data));

        // Return a response indicating success
        return back();
    }

    public function store_module_comment(Request $request)
    {
        // dd($request);
        // Validate incoming request data
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'module_id' => 'required|exists:modules,id',
        ]);
        

        // Create a new CourseAnnouncement instance
        $comment = new ModuleComment();
        $comment->comment = $validatedData['comment'];
        $comment->user_id = auth()->user()->id;
        $comment->module_id = $validatedData['module_id'];
        
        // Save the announcement
        $comment->save();

        $module = Module::find($request['module_id']);
        $course = Course::find($module->course_id);
        $teacher = User::find($course->author_id);
        $student_name = auth()->user()->lastname . ', ' . auth()->user()->firstname . ' ' . auth()->user()->middlename;
        $data = ["message" => $student_name . " commented on ".'"'. $module->name.'"'. " for course ".'"'. $course->name.'"'];
        Notification::send([$teacher], new CustomNotification($data));

        // Return a response indicating success
        return back();
    }

    public function save_edit(Request $request){
        $announcement = CourseAnnouncement::find($request->announcement_id);
        $announcement->announcement = $request->new_announcement;
        $announcement->save();

        return back()->with('success', 'Successfully updated the announcement.');
    }
}
