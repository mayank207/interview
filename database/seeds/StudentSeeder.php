<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
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
	        DB::table('student')->insert([
                'state_id' => $faker->numberBetween($min = 1, $max = 7),
	            'name' => $faker->name,
                'email' => $faker->email,
                'phone' => '9876543125',
                'attachment' =>'1609479229.png  ',
                'date' => $faker->dateTime($max = 'now', $timezone = null),
                'fresher' => 1,
                'expereince_year' => 0,
                'expereince_month' => 0,
	        ]);
	    }
    }
}
