<?php

namespace Database\Seeders;

use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = [
            'name' => 'Админ',
            'surname' => 'Админов',
            'patronymic' => 'Админович',
            'gender' => GenderEnum::Male,
            'role' => RoleEnum::Admin,
            'email' => 'admin@mail.ru',
            'phone_number' => '89091112233',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
        ];

        $user = [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronymic' => 'Иванович',
            'gender' => GenderEnum::Male,
            'role' => RoleEnum::User,
            'email' => 'user@mail.ru',
            'phone_number' => '89094445566',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
        ];

        User::insert($admin);
        User::insert($user);

        User::factory(20)
            ->create();
    }
}
