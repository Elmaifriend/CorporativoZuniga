<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\ClientFactory;
use Database\Factories\CommentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            "name" => "admin",
            "email" => "admin@admin.com",
            'password' => "admin",
        ]);

        $faker = Faker::create('es_ES'); 
        $titles = ['Lic.', 'Dr.', 'Dra.', 'Ing.', 'Mtro.', 'Mtra.', 'Abg.'];

        for ($i = 0; $i < 10; $i++) {
            $fullName = $faker->randomElement($titles) . ' ' . $faker->firstName() . ' ' . $faker->lastName();
            
            User::factory()->create([
                'name' => $fullName,
                'email' => strtolower(str_replace(['.', ' '], ['', ''], $fullName)) . $i . '@ejemplo.com',
            ]);
        }

        $this->call([
            ClientSeeder::class,
            ClientDocumentSeeder::class,
            ClientCaseSeeder::class,
            CommentSeeder::class,
            ProcedureSeeder::class,
            ProcedureDocumentSeeder::class,
            RecurrentPaymentSeeder::class,
            PaymentSeeder::class,
            AppointmentsSeeder::class,
            CommentSeeder::class,
            InternalAnnouncementSeeder::class,
        ]);
    }
}
