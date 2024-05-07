<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseAnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes([
    'verify' =>true
]);

// Accessible by everyone
//localhost:8000/
//knowledgethrive.online/team
Route::get('/', function () {
    return view('welcome');
});
Route::get('/team', function () {
    return view('team');
});
Route::get('/contact', function () {
    return view('contact');
});


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::post('/login/process', [UserController::class, 'process'])->name('process_login');



// Create Account Processing
Route::post('/store', [UserController::class, 'store'])->name('process_register');

// Accessible by the ones logged in
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', [UserController::class, 'inithome'])->name('home');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    Route::get('/account', [UserController::class, 'account'])->name('account');
    Route::post('/account/updatename', [UserController::class, 'updatename'])->name('updatename');
    Route::post('/account/updatepassword', [UserController::class, 'updatepassword'])->name('updatepassword');

    

    // Teacher
    Route::get('/user/1/home', [TeacherController::class, 'home'])->name('teacher.home');
    Route::get('/user/1/courses', [TeacherController::class, 'courses'])->name('teacher.courses.all');
    Route::get('/user/1/courses/archived', [TeacherController::class, 'archived'])->name('teacher.archived.all');
    Route::get('/user/1/course/{course}', [TeacherController::class, 'course'])->name('teacher.courses.course');
    Route::get('/user/1/course/{course}/modules', [TeacherController::class, 'modules'])->name('teacher.courses.modules');
    Route::get('/user/1/course/{course}/assessments', [TeacherController::class, 'assessments'])->name('teacher.courses.assessments');
    Route::get('/user/1/course/{course}/enrollees', [TeacherController::class, 'enrollees'])->name('teacher.courses.enrollees');
    Route::delete('/Course/enrollee/remove', [EnrollmentController::class, 'delete'])->name('teacher.enrollee.remove');
    Route::post('/give-points', [TeacherController::class, 'givepoints'])->name('teacher.givepoints');
    Route::post('/give-points-all', [TeacherController::class, 'givepointsall'])->name('teacher.givepointsall');

    // Course
    Route::get('/user/1/new-course', [CourseController::class, 'new'])->name('teacher.courses.new');
    Route::post('/user/1/new-course/save', [CourseController::class, 'save_new'])->name('teacher.courses.save_new');
    Route::delete('/Course/{course}', [CourseController::class, 'delete'])->name('teacher.courses.delete');
    Route::put('/user/1/courses/{course}/edit/save', [CourseController::class, 'update'])->name('teacher.courses.update');
    Route::get('/user/1/courses/{course}/edit', [CourseController::class, 'edit'])->name('teacher.courses.edit');
    Route::post('/user/1/courses/{course}/archive', [CourseController::class, 'archive'])->name('teacher.courses.archive');

    Route::put('/user/1/course/{course}/module/{module}/edit/save', [ModuleController::class, 'update'])->name('teacher.modules.update');
    Route::get('/user/1/course/{course}/module/{module}/edit', [ModuleController::class, 'edit'])->name('teacher.modules.edit');

    
    // Module
    Route::get('/user/1/{course}/modules', [ModuleController::class, 'modules'])->name('teacher.modules.all');
    // Module
    Route::get('/user/1/{course}/new-module', [ModuleController::class, 'new'])->name('teacher.modules.new');
    Route::post('/user/1/{course}/new-module/save', [ModuleController::class, 'save_new'])->name('teacher.modules.save_new');
    Route::delete('/Course/{course}/Module/{module}', [ModuleController::class, 'delete'])->name('teacher.modules.delete');
    Route::post('/module/upload-task-material', [ModuleController::class, 'uploadTaskMaterial'])->name('module.upload.taskmaterial');
    Route::post('/module/clear-task-material', [ModuleController::class, 'clearTaskMaterial'])->name('module.clear.taskmaterial');
    Route::get('/module/{id}/submissions', [ModuleController::class, 'viewSubmissions'])->name('module.submissions');
    Route::post('/module/view-submitted', [ModuleController::class, 'viewSubmitted'])->name('module.submitted');
    
    // Materials
    Route::get('/user/1/{course}/{module}/new-material', [MaterialController::class, 'new'])->name('teacher.materials.new');
    Route::post('/user/1/{course}/{module}/new-material/save', [MaterialController::class, 'save_new'])->name('teacher.materials.save_new');
    Route::delete('/Course/{course}/Module/{module}/Material/{material}', [MaterialController::class, 'delete'])->name('teacher.materials.delete');
    Route::get('/Course/{course}/Module/{module}/Material/{material}', [MaterialController::class, 'edit'])->name('teacher.materials.edit');
    Route::put('/update-material', [MaterialController::class, 'update'])->name('teacher.materials.update');
    
    // Announcement
    Route::get('/user/1/{course}/new-announcement', [CourseAnnouncementController::class, 'new'])->name('teacher.announcement.new');
    Route::post('/user/1/save-announcement', [CourseAnnouncementController::class, 'save_edit'])->name('announcement.saveedit');
    Route::post('/user/1/new-announcement/save', [CourseAnnouncementController::class, 'store'])->name('teacher.announcement.store');
    Route::post('/user/1/new-announcement-comment/save', [CourseAnnouncementController::class, 'store_comment'])->name('teacher.announcement.store_comment');
    Route::post('/user/1/new-module-comment/save', [CourseAnnouncementController::class, 'store_module_comment'])->name('teacher.module.store_comment');

    // Students
    Route::get('/user/2/home', [StudentController::class, 'show'])->name('student.home');
    Route::get('/user/2/enroll', [StudentController::class, 'enroll'])->name('student.enroll');
    Route::post('/user/2/enroll/save', [EnrollmentController::class, 'enroll_save'])->name('student.enroll.save');
    Route::get('/user/2/course/{course}', [StudentController::class, 'showCourse'])->name('student.show_course');
    Route::get('/user/2/course/{course}/learn', [StudentController::class, 'openCourse'])->name('student.open_course');
    Route::get('/user/2/course/{course}/certificate', [StudentController::class, 'showCertificate'])->name('student.show_certificate');

    // Assessments
    // Route::get('/user/1/{course_id}/{module_id}/new-assessment', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::get('/user/1/{course}/new-assessment', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::post('/user/1/{course}/new-assessment/save', [AssessmentController::class, 'store'])->name('assessments.store');
    Route::delete('/Course/{course}/Assessment/{assessment}', [AssessmentController::class, 'delete'])->name('teacher.assessments.delete');
    Route::post('/assessment/submit', [AssessmentController::class, 'submit'])->name('student.assessments.submit');
    Route::post('/assessment/calculate/', [AssessmentController::class, 'calculate'])->name('teacher.assessments.calculate');
    Route::post('/assessment/powerups/toggle', [AssessmentController::class, 'togglepowerups'])->name('teacher.assessments.togglepowerups');
    Route::get('/user/1/{course}/Assessment/{assessment}/edit', [AssessmentController::class, 'editpage'])->name('assessments.editpage');
    Route::put('/user/1/courses/{course}/edit-assessment/save', [AssessmentController::class, 'update'])->name('assessments.update');
    Route::get('/user/1/course/{course}/assessment/{id}/answers', [AssessmentController::class, 'getanswers'])->name('assessment.answers');
    Route::post('/download-answer', [AssessmentController::class, 'download'])->name('assessment.download');

    Route::post('/use-send-help', [AssessmentController::class, 'useSendHelp'])->name('assessment.SendHelp');
    Route::post('/use-50-50', [AssessmentController::class, 'use5050'])->name('assessment.5050');
    Route::post('/use-1-by-1', [AssessmentController::class, 'use1by1'])->name('assessment.1by1');

    Route::post('/assessment/answers/view', [AssessmentController::class, 'viewanswer'])->name('assessment.viewanswer');

    Route::post('/user/2/module/mark-as-done', [CourseProgressController::class, 'markAsDone'])->name('course.progress.markAsDone');


    // Certifications
    Route::get('/user/1/certifications', [TeacherController::class, 'certcourses'])->name('teacher.certifications.courses');
    Route::get('/user/1/certifications/{course}/certify', [TeacherController::class, 'certify'])->name('teacher.certify.students');
    
    // Generate Certificate
    Route::post('/user/1/certifications/{course}/certify/generate', [TeacherController::class, 'generate'])->name('teacher.certify.generate');
});





// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
