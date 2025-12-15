<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        Message::factory(10)->create()->each(function ($message) use ($users) {
            $message->recipients()->attach(
                $users->random(rand(1, 3))->pluck('id')
            );
        });
    }
}
