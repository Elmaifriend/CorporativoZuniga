<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientCase; // Importa el modelo ClientCase

class ClientCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 80 casos de clientes de prueba usando el ClientCaseFactory
        // Asume que ya existen clientes en la tabla 'clients'
        ClientCase::factory()->count(80)->create();
    }
}