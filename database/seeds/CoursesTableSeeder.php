<?php

use Illuminate\Database\Seeder;
use App\Teacher;
use App\Student;
use App\Course;
use App\Classe;
use App\Lesson;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_CN');

        $titles = ['初三尖子班', '初三超能班', '初二学霸班',];
        $students = Student::get();

        $teachers = Teacher::get();
        $i = 0;
        foreach ($teachers as $teacher) {
            $course = new Course();
            $course->teacher_id = $teacher->id;
            $course->title = $titles[$i % 3];
            $course->subject = '数学';
            $course->save();
            $i++;
            foreach ($students as $student) {
                if ($faker->boolean) {
                    $classe = New Classe();
                   $classe->course_id = $course->id;
                   $classe->student_id = $student->id;
                   $classe->name = $course->title;
                   $classe->save();
                }
            }
            for ($l=0;$l<10;$l++) {
                if ($faker->boolean) {
                    $lesson = new Lesson();
                    $lesson->subject = $faker->catchPhrase;
                    $lesson->course_id = $course->id;
                    $lesson->description = $faker->text($maxNbChars = 40);
                    $lesson->save();
                }
            }
        }
    }
}
