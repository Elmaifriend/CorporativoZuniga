<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Necesario para usar Attributes

class ClientCase extends Model
{
    /** @use HasFactory<\Database\Factories\ClientCaseFactory> */
    use HasFactory;

    protected $fillable = [
        "client_id",
        "case_name",
        "responsable_lawyer",
        "case_type",
        "courtroom",
        "external_expedient_number",
        "resume",
        "start_date",
        "stimated_finish_date",
        "real_finished_date",
        "status",
        "total_pricing",
    ];

    protected function paidPorcentage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Si el caso no tiene precio total definido o es cero, retorna 0
                $totalPricing = (float) $attributes['total_pricing'];
                if ($totalPricing <= 0) {
                    return 0;
                }

                // Carga la relación de pagos (si aún no está cargada)
                // y suma la cantidad pagada ('amount' en la tabla 'payments').
                $totalPaid = (float) $this->payments()->sum('amount');
                
                // Calcula el porcentaje pagado
                $percentage = ($totalPaid / $totalPricing) * 100;
                
                // Retorna el porcentaje redondeado a dos decimales
                return round($percentage, 2);
            },
        );
    }

    // --- RELACIONES ---

    public function client(){
        return $this->belongsTo(Client::class, "client_id");
    }

    public function procedures(){
        return $this->hasMany(Procedure::class, "case_id");
    }

    public function payments(){
        // Esta relación es crucial para el cálculo del porcentaje
        // Debe apuntar a la tabla de pagos y usar el morphMany correcto.
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function comments(){
        return $this->morphMany(Comment::class, "commentable");
    }
}