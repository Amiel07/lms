<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Material;
use App\Models\Enrollment;
use App\Models\Assessment;
use App\Models\Certificate;
use App\Models\CourseProgress;
use App\Models\CourseAnnouncement;
use App\Models\CourseComment;
use App\Models\MaterialProgress;
use App\Models\ModuleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

use setasign\Fpdi\Fpdi;

class StudentController extends Controller
{
    public function show(){
        $courses = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->where('enrollments.student_id', auth()->user()->reference_id)
        ->where('courses.hidden', false)
        ->select('courses.*')
        ->get();
        $certificates = Certificate::where('student_id', auth()->user()->id)->get();
        // dd($certificates);
        $notCompleted = collect();
        $completed = collect();

        foreach ($courses as $course){
            if (isCourseCompleted(auth()->user()->id, $course->id)){
                $completed->push($course);
            }
            else{
                $notCompleted->push($course);
            }
        }

        if (View::exists('student.home')){
            return view('student.home', ['completed_courses' => $completed, 'not_completed_courses' => $notCompleted, 'courses' => $courses, 'certificates' => $certificates]);
        }
        else{
            return abort(404);
        }
    }

    public function enroll(){
        if (View::exists('student.enroll')){
            return view('student.enroll');
        }
        else{
            return abort(404);
        }
    }

    public function showCourse($course_id) {
        // Retrieve course, modules, and materials based on the course_id
        $course = Course::find($course_id);
        $announcements = CourseAnnouncement::join('users AS u', 'course_announcements.user_id', '=', 'u.id')
            ->where('course_announcements.course_id', $course->id)
            ->orderBy('course_announcements.created_at', 'desc')
            ->get(['course_announcements.*', 'u.firstname', 'u.middlename', 'u.lastname', 'u.email']);

        $announcementIds = $announcements->pluck('id')->toArray();
        $comments = CourseComment::join('users AS uc', 'course_comments.user_id', '=', 'uc.id')
            ->whereIn('course_comments.announcement_id', $announcementIds)
            ->get(['course_comments.*', 'uc.firstname', 'uc.middlename', 'uc.lastname', 'uc.email']);


        return view('student.course', ['course' => $course, 'announcements' => $announcements, 'comments' => $comments]);
    }
    public function openCourse($course_id) {
        // Retrieve course, modules, and materials based on the course_id
        $course = Course::find($course_id);
        $modules = Module::where('course_id', $course_id)->get();
        $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
        $assessments = Assessment::where('course_id', $course->id)->get();
        // dd($assessments);
        foreach ($assessments as $key => $assessment) {
            // Convert key-value pairs to array of arrays
            $itemsArray = [];
            foreach ($assessment->items as $itemKey => $itemValue) {
                $itemsArray[] = [$itemKey, $itemValue];
            }
        
            // Shuffle the array of arrays
            shuffle($itemsArray);
        
            // Convert back to key-value pairs
            $shuffledItems = [];
            foreach ($itemsArray as $itemArray) {
                $shuffledItems[$itemArray[0]] = $itemArray[1];
            }
        
            // Assign the shuffled items back to the assessment
            $assessments[$key]->items = $shuffledItems;
        }
        $courseprogress = CourseProgress::whereIn('module_id', $modules->pluck('id'))->get();
        // $materialprogress = MaterialProgress::whereIn('material_id', $materials->pluck('id'))->get();
        
        $comments = ModuleComment::join('users AS uc', 'module_comments.user_id', '=', 'uc.id')
            ->whereIn('module_comments.module_id', $modules->pluck('id'))
            ->get(['module_comments.*','uc.firstname', 'uc.middlename', 'uc.lastname', 'uc.email']);


        if ($modules->isEmpty() || !$modules){
            return back()->with('error', 'This course does not have any modules yet.');
        }
        
        return view('student.learn', ['course' => $course, 'modules' => $modules, 'materials' => $materials, 'assessments' => $assessments, 'progress' => $courseprogress, 'comments' => $comments]);
    }

    public function showCertificate($course_id){
        if (Certificate::where('student_id', auth()->user()->id)->where('course_id', $course_id)->doesntExist()){
            return back()->withErrors(['certificate' => 'Your certificate is not generated yet or you have not completed the course yet.']);
        }

        $certificate = Certificate::where('student_id', auth()->user()->id)->where('course_id', $course_id)->first();
        $pdfTemplatePath = $certificate->file_uri;
        // dd($pdfTemplatePath);
        $pdf = new FPDI('l');
        $pdf->setSourceFile( $pdfTemplatePath );
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($tpl);
        $pdf->Output();

        return route($pdfTemplatePath);
    }

}
