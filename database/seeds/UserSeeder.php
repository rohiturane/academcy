<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
            'active'=>1,
            'role'=>1
        ]);
        for ($i=0; $i < 3; $i++) { 
	    	User::create([
	            'name' => str_random(8),
	            'email' => str_random(12).'@mail.com',
	            'password' => bcrypt('123456'),
                'active'=>1,
                'role'=>2
	        ]);
    	}
    }
}
