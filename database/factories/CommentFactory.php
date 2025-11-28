<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\ClientCase;
use App\Models\User; // 1. IMPORTAR el modelo User

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comment::class;

    private function getRandomUserId()
    {
        return User::inRandomOrder()->first()->id ?? User::factory();
    }

    public function definition(): array
    {
        $commentableTypes = [
            ClientCase::class,
        ];
        
        $commentableType = $this->faker->randomElement($commentableTypes);
        
        $commentableId = $commentableType::inRandomOrder()->first()->id;

        $statuses = ['Abierto', 'Pendiente', 'Resuelto'];
        $status = $this->faker->randomElement($statuses);
        
        $writedBy = $this->getRandomUserId();
        $assignedTo = $this->getRandomUserId();
        
        $solvedDate = ($status === 'Resuelto') 
            ? $this->faker->dateTimeBetween('-1 month', 'now') 
            : null;
     
        $attendedBy = ($status === 'Resuelto')
            ? $this->getRandomUserId()
            : null;
        
        return [
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            
            "body" => $this->faker->paragraph(2),
            "writed_by" => $writedBy, 
            "assigned_to" => $assignedTo, 
            "status" => $status,
            "attended_by" => $attendedBy,
            "solved_date" => $solvedDate,
        ];
    }
    
    public function solved(): Factory
    {
        return $this->state(function (array $attributes) {
            $userId = $this->getRandomUserId(); 
            return [
                'status' => 'Resuelto',
                'solved_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
                'attended_by' => $userId,
            ];
        });
    }
}