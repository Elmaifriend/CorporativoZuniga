<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientDocument; // Importa el modelo ClientDocument

class ClientDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 150 documentos de prueba.
        // Esto creará en promedio 3 documentos por cada cliente si tienes 50 clientes.
        ClientDocument::factory()->count(150)->create();
    }
}