<?php

namespace Database\Seeders;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrcreate([
            'username' => 'admin',
        ], [
            'username' => 'admin',
            'password' => bcrypt('123123'),
            'full_name' => 'Administrator',
            'status' => UserStatusEnum::Active->value,
        ]);

        User::factory(5000)->create();
    }
}
