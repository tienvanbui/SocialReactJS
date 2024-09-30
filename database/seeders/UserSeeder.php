<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Quynh',
                'email' => 'nguyenthicanquynh@gmail.com',
                'avatar' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&f=y',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('a12345678X')
            ],
            [
                'name' => 'Thanh',
                'email' => 'nguyenthithanh@gmail.com',
                'avatar' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=retro&f=y',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('a12345678X')
            ],
            [
                'name' => 'Huy',
                'email' => 'nguyenhuuhuy@gmail.com',
                'avatar' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=monsterid&f=y',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('a12345678X')
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
