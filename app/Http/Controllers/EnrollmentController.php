<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class EnrollmentController extends Controller
{
    public function enroll_save(Request $request){
        // Validate
        $validated = $request->validate([
            "invite_code" => 'required|min:6|max:6'
        ]);
        $courses = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->where('enrollments.student_id', auth()->user()->reference_id)
        ->select('courses.*')
        ->get();
        if (!$validated){
            return redirect(route('student.enroll', ['courses' => $courses]));
        }
        // Check if course exist
        $course = Course::where('invite_code', $request->invite_code)->get()->first();
        if (!$course){
            // dd("course not exist");
            $course = Course::all();
            return back()->with('error', 'Code not valid.');
        }

        // Check if enrolled already
        $isEnrolled = Enrollment::where('student_id', auth()->user()->reference_id)->where('course_id', $course->id)->exists();
        if ($isEnrolled){
            return back()->with('error', 'Already enrolled in this course.');
        }


        // Enroll
        $enrollment = ['student_id' => auth()->user()->reference_id, 'course_id' => $course->id];
        Enrollment::create($enrollment);

        $data = ["message" => "Someone just enrolled on your course " . '"' . $course->name . '"'];
        $user = User::find($course->author_id);
        Notification::send([$user], new CustomNotification($data));
        // CourseEnrollment::create($validated);
        
        if (View::exists('student.home')){
            $courses = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->where('enrollments.student_id', auth()->user()->reference_id)
            ->select('courses.*')
            ->get();
            return redirect(route('student.home', ['courses' => $courses]));
        }
        else{
            return abort(404);
        }
    }

    public function delete(Request $request){
        
        $enrollmentTarget = Enrollment::findOrFail($request['enrollment_id']);
        if ($enrollmentTarget){
            $enrollmentTarget->delete();
            $course = Course::find($enrollmentTarget->course_id);
            $data = ["message" => "You have removed on your course " . '"' . $course->name . '"'];
            $user = User::find($course->author_id);
            Notification::send([$user], new CustomNotification($data));

            return back()->with('success', 'Successfully removed the student!');
        }
        else{

            return back()->with('success', 'Failed to remove the student!');
        }
    }
}
