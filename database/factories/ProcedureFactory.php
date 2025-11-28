<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Procedure;
use App\Models\ClientCase; // Necesario para obtener un case_id existente

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedure>
 */
class ProcedureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Procedure::class;

    public function definition(): array
    {
        $statuses = ['Pendiente', 'En Progreso', 'Revisión', 'Completado', 'Detenido'];
        $priorities = ['Baja', 'Media', 'Alta', 'Urgente'];
        
        $status = $this->faker->randomElement($statuses);
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $limitDate = $this->faker->dateTimeBetween($startDate, '+3 months');
        
        $finishDate = null;
        if ($status === 'Completado') {
            $finishDate = $this->faker->dateTimeBetween($startDate, 'now');
        } elseif ($status === 'Revisión') {
            $finishDate = $this->faker->dateTimeBetween($startDate, 'now'); 
        }

        $lastUpdate = $finishDate ?? $this->faker->dateTimeBetween($startDate, 'now');
        $employees = ['Abg. Pérez', 'Asist. Gómez', 'Abg. Ruiz', 'Secretaria Díaz'];

        return [
            "case_id" => ClientCase::inRandomOrder()->first()->id ?? ClientCase::factory(), 
            
            "title" => $this->faker->catchPhrase(), 
            "responsable_employee" => $this->faker->randomElement($employees),
            "status" => $status,
            
            "starting_date" => $startDate,
            "last_update" => $lastUpdate,
            "finish_date" => $finishDate,
            "limit_date" => $limitDate,
            
            "priority" => $this->faker->randomElement($priorities),
            "order" => $this->faker->numberBetween(1, 10),
            "notes" => $this->faker->optional(0.6)->paragraph(2),
        ];
    }
}