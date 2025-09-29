<?php

namespace App\Services;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data, string $role): User
    {
        return DB::transaction(function () use ($data, $role) {

            // create user
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'phone'      => $data['phone'] ?? null,
                'city'      => $data['city'] ?? null,
                'country'      => $data['country'] ?? null,
                'state'      => $data['state'] ?? null,
            ]);

            $user->assignRole($role);

            // create teacher
            if ($role === 'teacher') {
                $teacher = Teacher::create([
                    'user_id' => $user->id,
                    'teaching_experience' => $data['teacher']['teaching_experience'] ?? null,
                    'online_teaching_experience' => $data['teacher']['online_teaching_experience'] ?? false,
                    'fluent_languages' => $data['teacher']['fluent_languages'] ?? null,
                    'availability_hours_per_week' => $data['teacher']['availability_hours_per_week'] ?? null,
                    'expected_class_time' => $data['teacher']['expected_class_time'] ?? null,
                    'position_applying_for' => $data['teacher']['position_applying_for'] ?? null,
                    'about' => $data['teacher']['about'] ?? null,
                    'resume' => $data['teacher']['resume'] ?? null,
                ]);
            }

            return $user;
        });
    }
}
