<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
use Illuminate\Http\Request;

class CourseProgressController extends Controller
{
    public function markAsDone(Request $request)
    {
        // Validate the request data if needed
        if ($request->has('is_assessment')){
            $request->merge(['is_assessment' => 1]);
        }else{
            $request->merge(['is_assessment' => 0]);
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'exists:modules,id',
            'is_assessment' => 'required',
        ]);

        // Get the authenticated user
        $user = auth()->user();
        // Check if the material progress record already exists for the user and material
        if ($request['is_assessment'] == '1'){
            $progress = CourseProgress::where('student_id', $user->id)
            ->where('course_id', $request->course_id)
            ->where('module_id', $request->module_id)
            ->where('is_assessment', 1)
            ->first();
        }
        else{
            $progress = CourseProgress::where('student_id', $user->id)
            ->where('course_id', $request->course_id)
            ->where('module_id', $request->module_id)
            ->where('is_assessment', 0)
            ->first();
        }

        // If the progress record exists, update it, otherwise create a new record
        if ($progress) {
            $progress->update(['is_completed' => !$progress->is_completed]);
            return back()->with('mark_not_done', 'Marked as not done.');
        } else {
            CourseProgress::create([
                'student_id' => $user->id,
                'course_id' => $request->course_id,
                'module_id' => $request->module_id,
                'is_completed' => true,
                'is_assessment' => $request->is_assessment,
            ]);
        }

        // You can return a response or redirect the user as needed
        return back()->with('mark_done', 'Marked as done.');
    }
}
