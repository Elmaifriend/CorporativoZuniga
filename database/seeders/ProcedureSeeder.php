<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Procedure; // Importa el modelo Procedure

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 200 procedimientos de prueba. 
        // Si tienes 80 casos, esto da un promedio de 2.5 procedimientos por caso.
        Procedure::factory()->count(900)->create();
    }
}