<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Procedure;
use App\Models\ClientCase; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedure>
 */
class ProcedureFactory extends Factory
{
    protected $model = Procedure::class;

    public function definition(): array
    {
        // 1. Usamos las llaves reales definidas en las opciones de Filament
        $statuses = ['pending', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];
        $intervals = ['daily', 'weekly', 'biweekly', 'monthly', 'bimonthly', 'yearly', 'custom'];
        
        $status = $this->faker->randomElement($statuses);
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $limitDate = $this->faker->dateTimeBetween($startDate, '+3 months');
        
        $finishDate = null;
        if ($status === 'completed') {
            $finishDate = $this->faker->dateTimeBetween($startDate, 'now');
        }

        $lastUpdate = $finishDate ?? $this->faker->dateTimeBetween($startDate, 'now');
        $employees = ['Abg. Pérez', 'Asist. Gómez', 'Abg. Ruiz', 'Secretaria Díaz'];

        // 2. Lógica para generar cuotas (ej. a veces 0, a veces más)
        $installments = $this->faker->randomElement([0, 3, 6, 12]);
        $installmentInterval = $installments > 0 ? $this->faker->randomElement($intervals) : null;

        return [
            "case_id" => ClientCase::inRandomOrder()->first()->id ?? ClientCase::factory(), 
            
            "title" => $this->faker->catchPhrase(), 
            "responsable_employee" => $this->faker->randomElement($employees),
            "status" => $status, // Ahora guarda 'pending', 'in_progress', etc.
            
            "starting_date" => $startDate,
            "last_update" => $lastUpdate,
            "finish_date" => $finishDate,
            "limit_date" => $limitDate,
            
            "priority" => $this->faker->randomElement($priorities), // Guarda 'low', 'medium', etc.
            "order" => $this->faker->numberBetween(1, 10),
            
            // 3. Agregamos los campos que están en tu $fillable
            "installments" => $installments,
            "installment_interval" => $installmentInterval,
            
            // NOTA: Se eliminó "notes" porque no está en la BD ni en el fillable
        ];
    }
}