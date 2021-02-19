<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'email' => 'admin@test.com',
            'password' => bcrypt('123456'),
            'name' => 'Arm Krit'
        ]);
    }
}
