<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment; // Importa el modelo Comment

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Genera 50 comentarios con el estado por defecto (Abierto/Pendiente)
        Comment::factory()->count(50)->create();
        
        // Genera 30 comentarios en el estado 'Resuelto' usando el 'solved' state
        Comment::factory()->solved()->count(30)->create();
        
        // Total: 80 comentarios
    }
}