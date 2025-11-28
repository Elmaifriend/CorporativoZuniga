<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RecurrentPayment;
use App\Models\Client; // Necesario para obtener un client_id existente

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecurrentPayment>
 */
class RecurrentPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RecurrentPayment::class;

    public function definition(): array
    {
        $frecuencies = ['Mensual', 'Bimestral', 'Trimestral', 'Anual'];
        $statuses = ['Activo', 'Pausado', 'Finalizado', 'Cancelado'];
        
        $frecuency = $this->faker->randomElement($frecuencies);
        $status = $this->faker->randomElement($statuses);
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            "client_id" => Client::inRandomOrder()->first()->id ?? Client::factory(), 
            "title" => $this->faker->randomElement(['Retainer Legal', 'Iguala de Servicios', 'Cuota de Mantenimiento', 'Plan de Pagos']),
            "description" => $this->faker->sentence(),
            "amount" => $this->faker->randomFloat(2, 1000, 20000),
            "frecuency" => $frecuency,
            "agreed_payment_day" => $this->faker->numberBetween(1, 28), 
            "contract_start_date" => $startDate,
            "status" => $status,
            "expiration_alert" => $this->faker->optional(0.4)->randomElement([3, 7, 15]), 
        ];
    }
    
    public function finished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => $this->faker->randomElement(['Finalizado', 'Cancelado']),
            ];
        });
    }
}