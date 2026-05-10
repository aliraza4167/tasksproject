<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(9)
        ->has(Task::factory()->count(10))
        ->has(Profile::factory())
        ->withoutTwoFactor()
        ->create();

        $ali = User::factory()
        ->has(Task::factory()->count(10))
        ->has(Profile::factory())
        ->withoutTwoFactor()
        ->create([
            'name' => 'Ali',
            'email' => 'ali@example.com',
        ]);

        
    }
}
