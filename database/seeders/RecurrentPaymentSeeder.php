<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecurrentPayment; // Importa el modelo RecurrentPayment

class RecurrentPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 40 pagos recurrentes activos o pausados
        RecurrentPayment::factory()->count(400)->create();
        
        // Genera 10 pagos recurrentes ya finalizados o cancelados
        RecurrentPayment::factory()->finished()->count(10)->create();
        
        // Total: 50 pagos recurrentes
    }
}