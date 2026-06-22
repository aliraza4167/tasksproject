<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Profile;
use App\Models\Thread;

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

        // Create threads with messages and participants
        $threads = Thread::factory(5)
        ->create();

        foreach ($threads as $thread) {
            // Add participants
            $thread->participants()->attach($ali->id);
            $randomUserId = $users->random()->id;
            // $thread->participants()->attach($users->random()->id);
            $thread->participants()->attach($randomUserId);

            // Create messages
            Message::factory(3)->create([
                'thread_id' => $thread->id,
                'user_id' => $ali->id,
            ]);


            Message::factory(3)->create([
                'thread_id' => $thread->id,
                'user_id' => $randomUserId,
            ]);
        }
    }
}
