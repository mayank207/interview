<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'admin','email'=>'admin@admin.com','password'=>bcrypt('12345678'),'profile_pictures'=>'default.jpg','role_id'=>1]
        ];
        User::insert($data);
    }
}
