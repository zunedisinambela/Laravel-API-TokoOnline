<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(48)->create();

        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
                'email_verified_at' => Carbon::now(),
                'api_token' => Str::random(10),
                'remember_token' => Str::random(10) ,
                'is_admin' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'user',
                'email' => 'user@mail.com',
                'username' => 'user',
                'password' => bcrypt('user123'),
                'email_verified_at' => Carbon::now(),
                'api_token' => Str::random(10),
                'remember_token' => Str::random(10) ,
                'is_admin' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        \App\Models\User::insert($users);
    }
}
