<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClientDocument; // Asegúrate de que el modelo esté importado
use App\Models\Client; // Necesario para obtener un client_id existente

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientDocument>
 */
class ClientDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ClientDocument::class;

    public function definition(): array
    {
        $documentTypes = [
            'Identificación Oficial', 
            'Comprobante de Domicilio', 
            'Contrato', 
            'Acta Constitutiva', 
            'Poder Legal', 
            'Otro'
        ];
        
        $documentType = $this->faker->randomElement($documentTypes);
        $fileName = $this->faker->slug(3) . '-' . $this->faker->uuid() . '.pdf';

        return [
            "client_id" => Client::inRandomOrder()->first()->id ?? Client::factory(),
            "document_type" => $documentType,
            "document_name" => $documentType . ' - ' . $this->faker->unique()->word(),
            "document_path" => 'documents/' . $fileName, 
            "notes" => $this->faker->optional(0.7)->sentence(), 
        ];
    }
}