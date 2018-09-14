<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Teacher;
use App\Student;
use App\Enums\UserType;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 10)->create();
        
    //     factory(App\User::class, 10)->create()->each(function($user) {
    //     	$faker = Faker\Factory::create();
    //     	App\Student::create(['name' => $faker->name, 'user_id' =>$user->id]);
        	
		  // });
        $faker = Faker\Factory::create('zh_CN');

        for ($i = 0; $i < 40; $i++) {
            $user = new User();
            $user->phone = $faker->e164PhoneNumber;
            $user->save();
            $user->name = $faker->name;
            $user->sex = $faker->boolean;
            $user->update();
            if ($i % 12 == 0) {
                $teacher = new Teacher();
                $user->role = UserType::Teacher;
                $user->save();
                $teacher->user_id = $user->id;
                $teacher->save();
            } else {
                $student = new Student();
                $user->role = UserType::Student;
                $user->save();
                $student->user_id = $user->id;
                $student->save();
            }
        }
    }
}
