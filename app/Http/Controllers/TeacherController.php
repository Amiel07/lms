<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Course;
use App\Models\Certificate;
use App\Models\CourseAnnouncement;
use App\Models\CourseComment;
use App\Models\ModuleComment;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\FpdfTpl;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function home(){
        if (View::exists('teacher.home')){
            $courses = Course::where('author_id', auth()->user()->id)->get();
            $courseIds = Course::where('author_id', auth()->user()->id)->pluck('id');
            $enrollments = Enrollment::whereIn('course_id', $courseIds)->get();
            // $enrolledUsers = DB::table('enrollments')
            //     ->join('users', 'enrollments.student_id', '=', 'users.reference_id')
            //     ->whereIn('enrollments.course_id', $courseIds)
            //     ->select('users.id', 'users.firstname', 'users.middlename', 'users.lastname')
            //     ->distinct()
            //     ->get();
            //     dd($enrolledUsers);
            // return view('teacher.home', ['courses' => $courses, 'enrolledUsers' => $enrolledUsers]);

            $user = auth()->user();
            $notifications = $user->notifications->take(5);
            return view('teacher.home', ['courses' => $courses, 'enrollments' => $enrollments, 'notifications' => $notifications]);
        }
        else{
            return abort(404);
        }
    }
    public function courses(){
        
        if (View::exists('teacher.courses.all')){
            $courses = Course::where('author_id', auth()->user()->id)
                ->where('hidden', false)
                ->get();
            $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
                ->where('courses.author_id', auth()->user()->id)
                ->select('modules.*')
                ->get();
            $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
            return view('teacher.courses.all', ['courses' => $courses, 'modules' => $modules, 'materials' => $materials]);
        }
        else{
            return abort(404);
        }
    }
    public function archived(){
        
        if (View::exists('teacher.courses.all-archived')){
            $courses = Course::where('author_id', auth()->user()->id)
                ->where('hidden', true)
                ->get();
            $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
                ->where('courses.author_id', auth()->user()->id)
                ->select('modules.*')
                ->get();
            $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
            return view('teacher.courses.all-archived', ['courses' => $courses, 'modules' => $modules, 'materials' => $materials]);
        }
        else{
            return abort(404);
        }
    }
    public function modules($course_id){
        
        if (View::exists('teacher.courses.all-modules')){
            $course = Course::find($course_id);
            $modules = Module::join('courses', 'modules.course_id', '=', 'courses.id')
                ->where('courses.author_id', auth()->user()->id)
                ->select('modules.*')
                ->get();
            $materials = Material::whereIn('module_id', $modules->pluck('id'))->get();
            $comments = ModuleComment::join('users AS uc', 'module_comments.user_id', '=', 'uc.id')
            ->whereIn('module_comments.module_id', $modules->pluck('id'))
            ->get(['module_comments.*','uc.firstname', 'uc.middlename', 'uc.lastname', 'uc.email']);
            return view('teacher.courses.all-modules', ['course' => $course, 'modules' => $modules, 'materials' => $materials, 'comments' => $comments]);
        }
        else{
            return abort(404);
        }
    }
    public function assessments($course_id){
        
        if (View::exists('teacher.courses.all-assessments')){
            $course = Course::find($course_id);
            $assessments = Assessment::where('course_id', $course->id)->get();
            return view('teacher.courses.all-assessments', ['course' => $course, 'assessments' => $assessments]);
        }
        else{
            return abort(404);
        }
    }

    public function enrollees($course_id){
        
        if (View::exists('teacher.courses.all-enrollees')){
            $course = Course::find($course_id);
            $enrollees = User::join('enrollments AS e', 'e.student_id', '=', 'users.reference_id')
                ->where('course_id', $course_id)
                ->get(['e.id AS enrollment_id', 'e.points AS points','users.id', 'users.firstname', 'users.middlename', 'users.lastname']);
            return view('teacher.courses.all-enrollees', ['course' => $course, 'enrollees' => $enrollees]);
        }
        else{
            return abort(404);
        }
    }

    public function certcourses(){
        
        if (View::exists('teacher.certifications.courses')){
            $courses = Course::where('author_id', auth()->user()->id)->get();
            
            return view('teacher.certifications.courses', ['courses' => $courses]);
        }
        else{
            return abort(404);
        }
    }

    public function course($course_id){
        if (View::exists('teacher.courses.course')){
            $course = Course::find($course_id);
            $announcements = CourseAnnouncement::join('users AS u', 'course_announcements.user_id', '=', 'u.id')
            ->where('course_announcements.user_id', auth()->user()->id)
            ->where('course_announcements.course_id', $course->id)
            ->orderBy('course_announcements.created_at', 'desc')
            ->get(['course_announcements.*', 'u.firstname', 'u.middlename', 'u.lastname', 'u.email']);
            // dd($announcements);

            $announcementIds = $announcements->pluck('id')->toArray();
            $comments = CourseComment::join('users AS uc', 'course_comments.user_id', '=', 'uc.id')
            ->whereIn('course_comments.announcement_id', $announcementIds)
            ->get(['course_comments.*', 'uc.firstname', 'uc.middlename', 'uc.lastname', 'uc.email']);
            return view('teacher.courses.course', ['course' => $course, 'announcements' => $announcements, 'comments' => $comments]);
        }
        else{
            return abort(404);
        }
    }

    public function certify($course_id){
        
        if (View::exists('teacher.certifications.certify')){
            $course = Course::find($course_id);
            $enrolled_students = User::select('users.*')
            ->join('enrollments', 'users.reference_id', '=', 'enrollments.student_id')
            ->where('enrollments.course_id', $course_id)
            ->where('users.type', 2)
            ->get();
            
            $students_completed = collect(); // completed
            $students_to_certify = collect(); // completed and not certified
            $already_certified = collect(); // completed and certified
            
            $certs = Certificate::all();
            foreach ($enrolled_students as $student){
                if (isCourseCompleted($student->id, $course->id)){
                    $students_completed->push($student);
                }
                if (isCourseCompleted($student->id, $course->id) && !$certs->contains(function ($cert) use ($student, $course) {
                    return $cert->student_id === $student->id && $cert->course_id === $course->id;
                    })) {
                    $students_to_certify->push($student);
                }
                if (isCourseCompleted($student->id, $course->id) && $certs->contains(function ($cert) use ($student, $course) {
                    return $cert->student_id === $student->id && $cert->course_id === $course->id;
                    })) {
                    $already_certified->push($student);
                }
            }
            // dd($students_completed);
            
            return view('teacher.certifications.certify', ['course' => $course, 'students' => $enrolled_students, 'completedStudents' => $students_completed, 'studentsToCertify' => $students_to_certify, 'alreadyCertified' => $already_certified]);
        }
        else{
            return abort(404);
        }
    }

    public function generate(Request $request, $course_id){
        $request->validate([
            'student_ids' => 'required|array|min:1',
        ], [
            'student_ids.required' => 'At least one student must be selected.',
        ]);


        
        $course = Course::find($course_id);
        $studentIds = $request->input('student_ids');
        $selectedUsers = User::whereIn('id', $studentIds)->get();
        
        $pdfTemplatePath = public_path('thrivecert/Certificate.pdf');
        
        
        foreach ($selectedUsers as $user) {
            $fullname = $user->firstname .' '. $user->middlename . ' ' . $user->lastname;
            $fullcourse = $course->course_code . ' - '. $course->name;

            
            $pdf = new FPDI('l');
            $pdf->setSourceFile( $pdfTemplatePath );
            $tpl = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($tpl);
            
            // $pdf->AddFont('Pinyon Script', '', storage_path('app/public/fonts/PinyonScript-Regular.ttf'));
            $pdf->SetFont('Helvetica', '', 40); // set font size
            $pdf->SetXY(10, 106); // set the position of the box
            $pdf->Cell(0, 10, $fullname, 0, 0, 'C');

            // Course
            $pdf->SetFont('Helvetica', 'B', 16); // set font size
            $pdf->SetXY(10, 134); // set the position of the box
            $pdf->Cell(0, 10, $fullcourse, 0, 0, 'C');

            // date
            $pdf->SetFont('Helvetica', '', 12); // set font size
            $pdf->SetXY(50, 168); // set the position of the box
            $pdf->Cell(52, 8, now()->format('Y-m-d'), 0, 0, 'C');


            $filename = 'certificate_'. Str::slug($fullname) . '-' . now()->format('YmdHis') . '.pdf';
    
            $pdf->Output(public_path('certificates/' . $filename), 'F');
    
            $uri = Storage::url('certificates/' . $filename);
            $certificate = new Certificate();
            $certificate->student_id = $user->id;
            $certificate->file_uri = public_path('certificates/' . $filename);
            $certificate->course_id = $course->id;
            $certificate->save();
        }

        return back()->with('success', 'Successfully generated Certificates.');

    }

    public function givepoints(Request $request){
        $enrollee = Enrollment::find($request->enrollment_id);
        $enrollee->points += $request->points;
        $enrollee->save();
        return back()->with('success', 'Score given.');
    }
    public function givepointsall(Request $request){
        // dd($request);
        $enrollees = Enrollment::where('course_id', $request->course_id)->get();
        
        foreach($enrollees as $enrollee){
            $enrollee->points += $request->points;
            $enrollee->save();
        }
        return back()->with('success', 'Points given to all.');
    }
}
