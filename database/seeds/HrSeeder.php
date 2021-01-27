<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        DB::table('users')->insert([
                'role_id' => 2,
	            'name' => $faker->name,
                'email' => $faker->email,
                'password'=>bcrypt('12345678'),
                'profile_pictures' =>'1609479229.png'
	        ]);
	    }
    }
}
