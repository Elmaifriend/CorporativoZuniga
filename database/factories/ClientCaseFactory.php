<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClientCase;
use App\Models\Client; // Necesario para obtener un client_id existente

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientCase>
 */
class ClientCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['Abierto', 'En Proceso', 'Pausado', 'Cerrado'];
        $caseTypes = ['Civil', 'Mercantil', 'Laboral', 'Penal', 'Familiar', 'Administrativo'];
        
        // Define las fechas de inicio y fin estimadas
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $stimatedFinishDate = $this->faker->dateTimeBetween($startDate, '+1 year');
        $status = $this->faker->randomElement($statuses);

        $realFinishedDate = ($status === 'Cerrado') 
            ? $this->faker->dateTimeBetween($startDate, 'now') 
            : null;

        $totalPricing = $this->faker->randomFloat(2, 5000, 500000);

        return [
            "client_id" => Client::inRandomOrder()->first()->id ?? Client::factory(), 
            "case_name" => $this->faker->catchPhrase() . ' vs ' . $this->faker->lastName(),
            "responsable_lawyer" => $this->faker->name(), 
            "case_type" => $this->faker->randomElement($caseTypes),
            "courtroom" => $this->faker->city() . ' Court',
            "external_expedient_number" => strtoupper($this->faker->bothify('EXP-#####-??')),
            "resume" => $this->faker->paragraph(),
            "start_date" => $startDate,
            "stimated_finish_date" => $stimatedFinishDate,
            "real_finished_date" => $realFinishedDate,
            "status" => $status,
            "total_pricing" => $totalPricing,
        ];
    }
}