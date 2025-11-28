<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcedureDocument; // Importa el modelo ProcedureDocument

class ProcedureDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 300 documentos de prueba. 
        // Si tienes 200 procedimientos, esto da un promedio de 1.5 documentos por procedimiento.
        ProcedureDocument::factory()->count(300)->create();
    }
}