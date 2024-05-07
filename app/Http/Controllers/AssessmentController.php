<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PointsUsage;
use App\Models\Module;
use App\Models\User;
use App\Models\Assessment;
use App\Models\AssessmentAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class AssessmentController extends Controller
{
    public function create($course_id){
        if (View::exists('teacher.assessments.new')){
            $course = Course::where("id", $course_id)->first();
            // $module = Module::where("id", $module_id)->first();
            return view('teacher.assessments.new', ['course'=> $course]);
        }
        else{
            return abort(404);
        }
    }

    public function editpage($course_id, $assessment_id){
        if (View::exists('teacher.assessments.edit')){
            $course = Course::where("id", $course_id)->first();
            // $module = Module::where("id", $module_id)->first();
            $assessment = Assessment::find($assessment_id);

            return view('teacher.assessments.edit', ['course'=> $course, 'assessment' => $assessment]);
        }
        else{
            return abort(404);
        }
    }

    public function store(Request $request, $course_id)
    {
        $itemsWithPictures = [];
        foreach ($request->items as $index => $item) {
            if (isset($item['picture']) && $item['picture']->isValid()) {
                $pictureFile = $item['picture'];
                $blobString = base64_encode(file_get_contents($pictureFile));
                $item['picture'] = $blobString;
            }
            $itemsWithPictures[$index] = $item;
        }
        
        // Merge the modified items with the original request data
        $requestData = $request->all();
        $requestData['items'] = $itemsWithPictures;
        $requestData['course_id'] = $course_id;
        $requestData['powerups'] = (isset($requestData['powerups'])) ? true : false;

        // Create the assessment using the merged data
        $assessment = Assessment::create($requestData);

        $course = Course::findOrFail($course_id);
        $data = ["message" => "You have created an assessment for course " . '"' . $course->name . '"'];
        $user = auth()->user();
        Notification::send([$user], new CustomNotification($data));

        // return response()->json(['message' => 'Assessment created successfully', 'assessment' => $assessment], 201);
        $course = Course::find($course_id);
        $assessments = Assessment::where('course_id', $course->id)->get();
        return redirect(route('teacher.courses.assessments', ['course' => $course, 'assessments' => $assessments]))->with('success', 'Successfully created the assessment!');
    }


    public function delete(Request $request){
        
        $assessmentTarget = Assessment::findOrFail($request['assessment_id']);
        if ($assessmentTarget){
            $assessmentTarget->delete();
            $course = Course::findOrFail($assessmentTarget->course_id);
            $data = ["message" => "You have deleted an assessment for course " . '"' . $course->name . '"'];
            $user = auth()->user();
            Notification::send([$user], new CustomNotification($data));

            return back()->with('success', 'Successfully deleted the assessment!');
        }
        else{

            return back()->with('success', 'Failed to delete the assessment!');
        }
    }


    public function submit(Request $request){
        // $json = json_encode($request->input('item'));
        
        $answers = new AssessmentAnswers;
        $answers->answers = $request->input('item');
        $answers->assessment_id = $request->assessment_id;
        $answers->student_id = auth()->user()->id;
        $answers->score = 0;
        $answers->save();

        $ans = AssessmentAnswers::where('student_id', auth()->user()->id)->where('assessment_id', $request->assessment_id)->first();
        $ans->score = calculateScore(auth()->user()->id, $request->assessment_id);
        $ans->save();
        return back()->with('success', 'Successfully submitted the assessment.');
    }


    public function calculate(Request $request){
        $assessment_id = $request->assessment_id;
        $answers = AssessmentAnswers::where('assessment_id', $request->assessment_id)->get();

        foreach ($answers as $answer){
            $student_id = $answer->student_id;

            // Helper to calculate score
            $new_score = calculateScore($student_id, $assessment_id);

            $answer->score = $new_score;
            $answer->save();
        }
        return back()->with('success', 'Successfully calculated scores.');
    }

    public function togglepowerups(Request $request){
        $assessment = Assessment::find($request->assessment_id);
        $assessment->powerups = !$assessment->powerups;
        $assessment->save();
        return back()->with('success', 'Toggled Powerups');
    }

    public function update(Request $request, $course_id){

   
        $course = Course::find($course_id);
        $assessment_id = $request->assessment_id;
        $assessment = Assessment::find($assessment_id);
        

        $itemsWithPictures = [];
        foreach ($request->items as $index => $item) {
            if (isset($item['picture']) && $item['picture']->isValid()) {
                $pictureFile = $item['picture'];
                $blobString = base64_encode(file_get_contents($pictureFile));
                $item['picture'] = $blobString;
            }
            $correctChoice = isset($item['correct_choice']) && is_array($item['correct_choice']) ? $item['correct_choice'] : [];
            $item['correct_choice'] = $correctChoice;
            $itemsWithPictures[$index] = $item;
        }

        // dd($itemsWithPictures);
        $assessment->assessment_name = $request->assessment_name;
        $assessment->direction = $request->direction;
        $assessment->powerups = ($request->powerups) ? 1 : 0;
        $assessment->items = $itemsWithPictures;

        $assessment->save();
        return redirect(route('teacher.courses.assessments', ['course' => $course->id]))->with('success', 'Successfully updated quiz.');
    }



    public function useSendHelp(Request $request){
        
        $assessment_id = $request->input('data')['assessment_id'];
        
        $course_id = $request->input('data')['course_id'];
        
        $enrollee = Enrollment::where('student_id', auth()->user()->reference_id)->where('course_id', $course_id)->first();
        

        $pointUsage = PointsUsage::firstOrCreate(
            ['student_id' => auth()->user()->id, 'assessment_id' => $assessment_id],
            ['used_points' => 0]
        );
    
        if ($enrollee->points >= 4 && ($pointUsage->used_points + 4) <= 9){
            $pointUsage->used_points += 4;
            $pointUsage->save();
            $enrollee->points -= 4;
            $enrollee->save();

            $assessment = Assessment::find($assessment_id);
            return response()->json(['eligible' => true, 'remaining_points' => $enrollee->points, 'assessment_items' => $assessment->items]);
        }
        else{
            return response()->json(['eligible' => false]);
        }
    }

    public function use5050(Request $request){
        
        $assessment_id = $request->input('data')['assessment_id'];
        
        $course_id = $request->input('data')['course_id'];
        
        $enrollee = Enrollment::where('student_id', auth()->user()->reference_id)->where('course_id', $course_id)->first();
        

        $pointUsage = PointsUsage::firstOrCreate(
            ['student_id' => auth()->user()->id, 'assessment_id' => $assessment_id],
            ['used_points' => 0]
        );
    
        if ($enrollee->points >= 3 && ($pointUsage->used_points + 3) <= 9){
            $pointUsage->used_points += 3;
            $pointUsage->save();
            $enrollee->points -= 3;
            $enrollee->save();

            $assessment = Assessment::find($assessment_id);
            return response()->json(['eligible' => true, 'remaining_points' => $enrollee->points, 'assessment_items' => $assessment->items]);
        }
        else{
            return response()->json(['eligible' => false]);
        }
    }

    public function use1by1(Request $request){
        
        $assessment_id = $request->input('data')['assessment_id'];
        
        $course_id = $request->input('data')['course_id'];
        
        $enrollee = Enrollment::where('student_id', auth()->user()->reference_id)->where('course_id', $course_id)->first();
        

        $pointUsage = PointsUsage::firstOrCreate(
            ['student_id' => auth()->user()->id, 'assessment_id' => $assessment_id],
            ['used_points' => 0]
        );
    
        if ($enrollee->points >= 2 && ($pointUsage->used_points + 2) <= 9){
            $pointUsage->used_points += 2;
            $pointUsage->save();
            $enrollee->points -= 2;
            $enrollee->save();

            $assessment = Assessment::find($assessment_id);
            return response()->json(['eligible' => true, 'remaining_points' => $enrollee->points, 'assessment_items' => $assessment->items]);
        }
        else{
            return response()->json(['eligible' => false]);
        }
    }



    public function getanswers($course_id, $assessment_id){
        if (View::exists('teacher.assessments.all-answers')){
            $course = Course::find($course_id);
            $enrollees = User::join('enrollments AS e', 'e.student_id', '=', 'users.reference_id')
                ->where('course_id', $course_id)
                ->get(['e.id AS enrollment_id', 'users.id AS student_id', 'e.points AS points','users.id', 'users.firstname', 'users.middlename', 'users.lastname']);
            $assessment = Assessment::find($assessment_id);
            return view('teacher.assessments.all-answers', ['course' => $course, 'enrollees' => $enrollees, 'assessment' => $assessment]);
        }
        else{
            return abort(404);
        }
    }


    public function viewanswer(Request $request){
        $student = User::find($request->student_id);
        $assessment = Assessment::find($request->assessment_id);
        
        $answer = AssessmentAnswers::where('student_id', $student->id)->where('assessment_id', $request->assessment_id)->first();
        if (!$answer){
            return back()->with('error', 'Test not taken for the student.');
        }
        return view('teacher.assessments.viewanswer', ['student' => $student, 'answers' => $answer, 'assessment' => $assessment]);
    }
    public function download(Request $request){
        $course = Course::find($request->course_id);
        $assessment = Assessment::find($request->assessment_id);

        $takers = User::join('assessment_answers AS a', 'a.student_id', '=', 'users.id')
            ->where('assessment_id', $request->assessment_id)
            ->get(['users.lastname', 'users.firstname', 'users.middlename', 'a.score']);
        
        $selectedFields = ['Lastname', 'Firstname', 'Middlename', 'Score'];
        $csvData = fopen('php://temp', 'w');
        fputcsv($csvData, $selectedFields);

        foreach ($takers as $taker) {
            fputcsv($csvData, $taker->toArray());
        }

        rewind($csvData);
        $csvContent = stream_get_contents($csvData);
        fclose($csvData);

        $filename = $assessment->id . '_' . $course->course_code . '_' . $course->name . '_' . $assessment->assessment_name . '.csv';

        return response()->streamDownload(function () use ($csvContent) {
            echo $csvContent;
        }, $filename);
    }
}
