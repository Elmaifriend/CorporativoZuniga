<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProcedureDocument;
use App\Models\Procedure; // Necesario para obtener un procedure_id existente

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProcedureDocument>
 */
class ProcedureDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProcedureDocument::class;

    public function definition(): array
    {
        $documentNames = [
            'Demanda Inicial', 
            'Contestación', 
            'Evidencia Fotográfica', 
            'Escrito de Prueba', 
            'Resolución Judicial',
            'Cédula de Notificación'
        ];
        
        $documentName = $this->faker->randomElement($documentNames);
        $extensions = ['pdf', 'docx', 'jpg', 'zip']; 
        $extension = $this->faker->randomElement($extensions);
        $fileName = $this->faker->slug(3) . '.' . $extension;


        return [
            "procedure_id" => Procedure::inRandomOrder()->first()->id, 
            "name" => $documentName . ' - ' . $this->faker->word(),
            "file_path" => 'procedures_docs/' . $fileName, 
            "notes" => $this->faker->optional(0.5)->sentence(),
        ];
    }
}