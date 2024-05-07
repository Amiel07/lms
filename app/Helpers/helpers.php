<?php

use App\Models\Assessment;
use App\Models\AssessmentAnswers;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Course;
use App\Models\CourseProgress;

if (!function_exists('isCourseCompleted')) {
    function isCourseCompleted($studentId, $courseId)
    {
        
        // Get the IDs of all modules in the course
        $modules = Module::where('course_id', $courseId)->get();
        $assessments = Assessment::where('course_id', $courseId)->get();
        
        foreach ($modules as $module) {
            // Check if there's any entry in CourseProgress for this module and student
            $courseProgress = CourseProgress::where('student_id', $studentId)
                                                ->where('module_id', $module->id)
                                                ->where('is_assessment', false)
                                                ->first();
            
            // If there's no entry or if the module is not completed, return false
            if (!$courseProgress || !$courseProgress->is_completed) {
                return false;
            }
        }
        foreach ($assessments as $assessment){
            if (!isAssessmentDone($studentId, $assessment->id)){
                return false;
            }
        }
        

        // $assessments = Assessment::where('course_id', $courseId)->get();
        // foreach ($assessments as $assessment) {
        //     // Check if there's any entry in CourseProgress for this module and student
        //     $courseProgress = CourseProgress::where('student_id', $studentId)
        //                                         ->where('module_id', $assessment->id)
        //                                         ->where('is_assessment', true)
        //                                         ->first();

        //     // If there's no entry or if the module is not completed, return false
        //     if (!$courseProgress || !$courseProgress->is_completed) {
        //         return false;
        //     }
        // }
 
         // All materials in all modules are completed for the student, return true
         return true;
    }
}

if (!function_exists('getPoints')) {
    function getPoints($studentId, $courseId){
        $enrollee = Enrollment::where('student_id', $studentId)->where('course_id', $courseId)->first();
        return $enrollee->points;
    }
}
if (!function_exists('moduleCount')) {
    function moduleCount($courseId){
        $modules = Module::where('course_id', $courseId)->get();
        return $modules->count();
    }
}

if (!function_exists('getSubmittedFiles')) {
    function getSubmittedFiles($student_id, $course_id, $module_id){

        $files = [];
        $directory = public_path('files/student_uploads');
        $pattern = "{$student_id}_{$course_id}_{$module_id}_*";
        // Get files matching the pattern
        $matchingFiles = glob("{$directory}/{$pattern}");
        
        foreach ($matchingFiles as $file) {
            
            // Extract filename and filesize
            $filename = basename($file);
            $filesize = filesize($file);

            $decimals = 2;
            if ($filesize === 0) return '0 Bytes';
        
            $k = 1024;
            $dm = $decimals < 0 ? 0 : $decimals;
            $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            $i = floor(log($filesize) / log($k));
        
            $filesize = number_format($filesize / pow($k, $i), $dm) . ' ' . $sizes[$i];
            

            // Construct filepath
            $filepath = url('/files/student_uploads/' . $filename);

            // Create object and add to files array
            $files[] = (object) [
                'filename' => $filename,
                'filepath' => $filepath,
                'filesize' => $filesize,
            ];
        }

        return $files;
    }
}

if (!function_exists('assessmentPoints')) {
    function assessmentPoints($assessment){
        $points = 0;
        foreach ($assessment->items as $item){
            $points += $item['points'];
        }

        return $points;
    }
}

if (!function_exists('studentScore')) {
    function studentScore($student_id, $assessment_id){
        $record = AssessmentAnswers::where('assessment_id', $assessment_id)
            ->where('student_id', $student_id)
            ->first();
        if ($record !== null){
            return $record->score;
        }
        return 0;
    }
}
if (!function_exists('getCorrectChoices')) {
    function getCorrectChoices($assessment_id, $key){
        $assessment = Assessment::find($assessment_id);
        return $items;
    }
}

// Calculate score
if (!function_exists('calculateScore')) {
    function calculateScore($student_id, $assessment_id){
        $record = AssessmentAnswers::where('assessment_id', $assessment_id)
            ->where('student_id', $student_id)
            ->first();

        if ($record === null){
            return 0;
        }
        
        $assessment = Assessment::find($assessment_id);
        $assessmentItems = $assessment->items;
        $studentAnswers = $record->answers;

        $totalScore = 0;
        // dd($assessmentItems, $studentAnswers);

        foreach ($assessmentItems as $itemId => $item) {
            // Check if the item has a score
            if (isset($item['points'])) {
                $points = floatval($item['points']);
            } else {
                $points = 0;
            }

            // Check if the student has provided an answer for this item
            if (!isset($studentAnswers[$itemId])) {
                // $totalScore += $points; // Add full points if no answer provided
                continue;
            }

            $studentAnswer = $studentAnswers[$itemId];
            
            // Check the answer type
            switch ($item['answer_type']) {
                case 'single':
                    if (strpos($item['correct_answer'], '<>') !== false) {
                        // Handle range format (e.g., "2<>5")
                        $correctAnswersRange = explode('<>', $item['correct_answer']);
                        $start = floatval($correctAnswersRange[0]);
                        $end = floatval($correctAnswersRange[1]);
                        $studentAnswer = floatval($studentAnswer);
                        if ($studentAnswer >= $start && $studentAnswer <= $end) {
                            $totalScore += $points;
                        }
                    } else {
                        // Handle individual answers separated by semicolons (e.g., "2;3;4;5")
                        $correctAnswers = explode(';', $item['correct_answer']);
                        if (in_array($studentAnswer, $correctAnswers)) {
                            $totalScore += $points;
                        }
                    }
                    
                    break;

                case 'multiple':
                    $correctAnswers = $item['correct_answers'];
                    $studentChoices = $studentAnswer['answers'];
                    $scorePerChoice = $points / count($correctAnswers);
                    
                    $correct = true;
                    foreach ($correctAnswers as $index => $correctAnswer) {
                        if (!isset($studentChoices[$index]) || $studentChoices[$index] != $correctAnswer) {
                            $correct = false;
                            break;
                        }
                    }

                    if ($correct) {
                        $totalScore += $points;
                    } else {
                        $totalScore += $scorePerChoice * count(array_intersect($studentChoices, $correctAnswers));
                    }

                    
                    break;

                case 'multiple_choice':
                    $correctChoices = $item['correct_choice'];
                    if ($studentAnswer == $correctChoices[0]) {
                        $totalScore += $points;
                    }
                    break;

                case 'long':
                default:
                    // No points for long answers
                    break;
            }
        }
        return $totalScore;
    }
}

if (!function_exists('isAssessmentDone')) {
    function isAssessmentDone($student_id, $assessment_id){
        $record = AssessmentAnswers::where('assessment_id', $assessment_id)
            ->where('student_id', $student_id)
            ->first();
        
        return $record !== null;
    }
}

if (!function_exists('completedModuleCount')) {
    function completedModuleCount($studentId, $courseId)
    {
        
        // Get the IDs of all modules in the course
        $modules = Module::where('course_id', $courseId)->get();
        $incomplete = 0;
    
        foreach ($modules as $module) {
            // Check if there's any entry in CourseProgress for this module and student
            $courseProgress = CourseProgress::where('student_id', $studentId)
                                                ->where('module_id', $module->id)
                                                ->first();

            // If there's no entry or if the module is not completed, return false
            if (!$courseProgress || !$courseProgress->is_completed) {
                $incomplete += 1;
            }
        }
 
         // All materials in all modules are completed for the student, return true
         $completed = $modules->count() - $incomplete;
         return $completed;
    }
}


if (!function_exists("materialFileType")){
    function materialFileType($string, $formats) {
        // Iterate over each video format
        foreach ($formats as $format) {
            // Check if the string ends with the current format
            if (substr($string, -strlen($format)) === $format) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists("getUploadedFiles")){
    function getUploadedFiles($course_id, $module_id) {
        $user_id = auth()->user()->id;
        $course_id = Course::find($course_id)->id;
        $module_id = Module::find($module_id)->id;

        $files = [];
        $directory = public_path('files/student_uploads');
        $pattern = "{$user_id}_{$course_id}_{$module_id}_*";

        // Get files matching the pattern
        $matchingFiles = glob("{$directory}/{$pattern}");
        
        foreach ($matchingFiles as $file) {
            
            // Extract filename and filesize
            $filename = basename($file);
            $filesize = filesize($file);

            $decimals = 2;
            if ($filesize === 0) return '0 Bytes';
        
            $k = 1024;
            $dm = $decimals < 0 ? 0 : $decimals;
            $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            $i = floor(log($filesize) / log($k));
        
            $filesize = number_format($filesize / pow($k, $i), $dm) . ' ' . $sizes[$i];
            

            // Construct filepath
            $filepath = url('/files/student_uploads/' . $filename);

            // Create object and add to files array
            $files[] = (object) [
                'filename' => $filename,
                'filepath' => $filepath,
                'filesize' => $filesize,
            ];
        }

        return $files;
    }
}