<?php

namespace Database\Seeders;

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
            'name' => 'Van Duc',
            'email' => 'hoduc589@gmail.com',
            'password' => bcrypt('123456'),
            'thumbnail' => '',
            'is_admin' => "1"
        ]);
    }
}
