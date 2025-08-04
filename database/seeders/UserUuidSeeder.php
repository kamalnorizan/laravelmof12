<?php

namespace Database\Seeders;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserUuidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::each(function ($user) {
            if (is_null($user->uuid)) {
                $user->uuid = (string) Uuid::uuid4();
                $user->save();
            }
        });
    }
}
