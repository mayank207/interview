<?php

use App\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['tech'=>'laravel'],
            ['tech'=>'javascript'],
            ['tech'=>'jquery'],
            ['tech'=>'html'],
            ['tech'=>'android'],
            ['tech'=>'ios'],
            ['tech'=>'python'],
            ['tech'=>'react native'],
            ['tech'=>'css'],
            ['tech'=>'reactjs'],
        ];
        Technology::insert($data);
    }
}
