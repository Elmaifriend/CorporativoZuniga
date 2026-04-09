<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Procedure;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        // Ejemplo 1: Crear 2 documentos para cada Cliente existente
        Client::all()->each(function ($client) {
            $client->documents()->saveMany(
                Document::factory(2)->make()
            );
        });

        // Ejemplo 2: Crear 1 documento para cada Procedimiento existente
        Procedure::all()->each(function ($procedure) {
            $procedure->documents()->saveMany(
                Document::factory(1)->make()
            );
        });
    }
}