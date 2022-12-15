<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        User::create([
            'role' => 'user',
            'email' => 'user1@user1.com',
            'username' => 'user1',
            'password' => bcrypt('user1'),
        ]);

        User::create([
            'role' => 'user',
            'email' => 'user2@user2.com',
            'username' => 'user2',
            'password' => bcrypt('user2'),
        ]);
    }
}
