<?php

use App\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['status'=>'new applicant'],
            ['status'=>'hr round'],
            ['status'=>'technical'],
            ['status'=>'practical'],
            ['status'=>'offered'],
            ['status'=>'rejected'],
            ['status'=>'hold']
        ];
        State::insert($data);
    }
}
