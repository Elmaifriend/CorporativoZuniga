<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment; // Importa el modelo Payment

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 100 pagos de prueba.
        // Esto creará una mezcla de pagos asociados a clientes y a casos.
        Payment::factory()->count(1000)->create();
    }
}