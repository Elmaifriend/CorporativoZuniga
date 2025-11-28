<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Client;
use App\Models\ClientCase;
use App\Models\RecurrentPayment; // ¡Añadido!

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Payment::class;

    public function definition(): array
    {
        $paymentableTypes = [
            ClientCase::class,
            RecurrentPayment::class, 
        ];
        
        $paymentableType = $this->faker->randomElement($paymentableTypes);
        $paymentableId = $paymentableType::inRandomOrder()->first()->id;

        $clientId = null;
        if ($paymentableType === ClientCase::class) {
            $clientId = ClientCase::find($paymentableId)?->client_id ?? Client::inRandomOrder()->first()->id;
        } elseif ($paymentableType === RecurrentPayment::class) {
            $clientId = RecurrentPayment::find($paymentableId)?->client_id ?? Client::inRandomOrder()->first()->id;
        } else {
             $clientId = Client::inRandomOrder()->first()->id;
        }
        
        $paymentMethods = ['Transferencia', 'Efectivo', 'Tarjeta de Crédito/Débito', 'Cheque'];
        $concepts = ['Honorarios de Caso', 'Pago de Igualas', 'Anticipo', 'Cuota Recurrente', 'Liquidación'];
        $concept = ($paymentableType === RecurrentPayment::class) 
            ? $this->faker->randomElement(['Cuota Mensual Recurrente', 'Pago de Iguala'])
            : $this->faker->randomElement(['Anticipo de Caso', 'Pago de Honorarios de Caso']);


        return [
            "client_id" => $clientId,
            "amount" => $this->faker->randomFloat(2, 500, 50000), 
            "payment_metod" => $this->faker->randomElement($paymentMethods),
            "concept" => $concept,
            "transaction_reference" => $this->faker->optional(0.8)->bothify('TRX-######-???'), 
            'paymentable_id' => $paymentableId,
            'paymentable_type' => $paymentableType,
        ];
    }
}