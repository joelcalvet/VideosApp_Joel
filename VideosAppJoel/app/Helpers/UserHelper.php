<?php

namespace App\Helpers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserHelper
{
    public static function createDefaultUser()
    {
        $user = User::create([
            'name' => config('users.default.name'),
            'email' => config('users.default.email'),
            'password' => Hash::make(config('users.default.password')),
        ]);

        $team = Team::forceCreate([
            'name' => 'Default Team',
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $user->teams()->attach($team); // Associar l'equip a l'usuari

        return $user;
    }

    public static function createDefaultTeacher()
    {
        $teacher = User::create([
            'name' => config('users.teacher.name'),
            'email' => config('users.teacher.email'),
            'password' => Hash::make(config('users.teacher.password')),
        ]);

        $team = Team::forceCreate([
            'name' => 'Default Team',
            'user_id' => $teacher->id,
            'personal_team' => true,
        ]);

        $teacher->teams()->attach($team); // Associar l'equip al professor

        return $teacher;
    }
}
