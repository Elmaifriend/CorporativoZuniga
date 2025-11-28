<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client; // Importa el modelo Client

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 50 clientes de prueba usando el ClientFactory
        Client::factory()->count(50)->create();

        // Opcionalmente, puedes crear un cliente específico si lo necesitas
        /*
        Client::factory()->create([
            'full_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            // ... otros campos
        ]);
        */
    }
}