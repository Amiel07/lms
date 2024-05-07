<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assessment;
use App\Models\Material;
use App\Models\Module;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'reference_id' => '111111',
            'firstname' => 'Juan',
            'middlename' => 'A',
            'lastname' => 'Dela Cruz',
            'verification_token' => Str::random(60),
            'email' => 'teacher@example.com',
            'email_verified_at' => '2024-03-22',
            'password' => bcrypt('12345678'), // Change 'password' to the desired password
            'type' => '1', 
        ]);
        User::create([
            'reference_id' => '222222',
            'firstname' => 'John',
            'middlename' => 'A',
            'lastname' => 'Doe',
            'verification_token' => Str::random(60),
            'email' => 'student1@example.com',
            'email_verified_at' => '2024-03-22',
            'password' => bcrypt('12345678'), // Change 'password' to the desired password
            'type' => '2',
        ]);
        User::create([
            'reference_id' => '333333',
            'firstname' => 'John',
            'middlename' => 'B',
            'lastname' => 'Smith',
            'verification_token' => Str::random(60),
            'email' => 'student2@example.com',
            'email_verified_at' => '2024-03-22',
            'password' => bcrypt('12345678'), // Change 'password' to the desired password
            'type' => '2',
        ]);
        Course::create([
            'course_code' => 'CS 50',
            'name' => 'Programming',
            'description' => 'Free and Open Course',
            'meeting_link' => 'https://meet.google.com/ngr-xdac-uio',
            'power_ups' => '1',
            'author_id' => '1',
            'invite_code' => 'qwerty',
            'hidden' => '0',
        ]);
        Enrollment::create([
            'student_id' => '222222',
            'course_id' => '1',
            'points' => '20',
        ]);
        Enrollment::create([
            'student_id' => '333333',
            'course_id' => '1',
            'points' => '20',
        ]);
        Module::create([
            'name' => 'Module 1',
            'description' => 'Algorithms',
            'is_task' => '1',
            'course_id' => '1',
            'hidden' => '0',
        ]);
        Module::create([
            'name' => 'Module 2',
            'description' => 'Data Structures',
            'is_task' => '0',
            'course_id' => '1',
            'hidden' => '0',
        ]);
        Material::create([
            'name' => 'Link 1',
            'type' => '2',
            'resource' => 'https://meet.google.com/ngr-xdac-uio',
            'module_id' => '1',
            'hidden' => '0',
        ]);
        Material::create([
            'name' => 'PDF 1',
            'type' => '1',
            'resource' => '1_1_Module 1 Lecture.pdf',
            'module_id' => '1',
            'hidden' => '0',
        ]);
        Material::create([
            'name' => 'Link 2',
            'type' => '2',
            'resource' => 'https://meet.google.com/ngr-xdac-uio',
            'module_id' => '2',
            'hidden' => '0',
        ]);
        Material::create([
            'name' => 'Video 1',
            'type' => '1',
            'resource' => '1_2_samplevideo.mp4',
            'module_id' => '2',
            'hidden' => '0',
        ]);
        Assessment::create([
            'assessment_name' => 'Modular Quiz 1',
            'direction' => 'Please answer all the questions.',
            'items' => json_decode('{"1":{"points":"5","question":"What is 1 + 1?","answer_type":"single","correct_answer":"2;2.0"},"2":{"points":"10","question":"What is _ + 3 = 3","answer_type":"multiple","correct_answers":["0"]},"3":{"points":"20","question":"Write essay about the life and works of Rizal","answer_type":"long"},"4":{"points":"5","question":"What is 2 + 2?","answer_type":"multiple_choice","choices":["1","2","4"],"correct_choice":["4"]}}'),
            'powerups' => '1',
            'course_id' => '1',
        ]);
        Assessment::create([
            'assessment_name' => 'Final Test',
            'direction' => 'Multiple Choice. Make sure to leave an answer, otherwise you will not get points for that item.',
            'items' => json_decode('{"1":{"points":"10","question":"Who is the Author of Harry Potter?","answer_type":"multiple_choice","choices":["JK Rowling","Dan Brown","William Shakespeare"],"correct_choice":["JK Rowling"]},"2":{"points":"5","question":"What is 50% of 10?","answer_type":"multiple_choice","choices":["6","4","5","3"],"correct_choice":["5"]},"3":{"points":"30","question":"Which equation is right.","answer_type":"multiple_choice","choices":["2x + 1 = 3; x=1","x + 1 = 2; x=2","x + x = 3; x=1","2x + 1 = 3; x=5"],"correct_choice":["2x + 1 = 3; x=1"]}}'),
            'powerups' => '1',
            'course_id' => '1',
        ]);
    }
}
