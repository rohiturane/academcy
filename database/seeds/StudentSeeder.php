<?php

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 3; $i++) { 
	    	Student::create([
	            'uuid' => (string) Str::orderedUuid(),
	            'first_name' => str_random(6),
                'middle_name' => str_random(6),
                'last_name' => str_random(6),
                'email' => str_random(12).'@mail.com',
	            'mobile' => '1234567890',
                'status'=>1
	        ]);
    	}
    }
}
