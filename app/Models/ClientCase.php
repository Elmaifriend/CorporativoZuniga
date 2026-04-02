<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Necesario para usar Attributes
use App\Models\Document;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Enums\PaymentStatus;

class ClientCase extends Model
{
    /** @use HasFactory<\Database\Factories\ClientCaseFactory> */
    use HasFactory;

    protected $fillable = [
        "client_id",
        "case_name",
        "responsable_lawyer",
        "case_type",
        "case_sub_type",
        //"courtroom",
        "external_expedient_number",
        "resume",
        "start_date",
        "stimated_finish_date",
        "real_finished_date",
        "status",
        "total_pricing",
        "billing_mode",
    ];

    protected function paidPorcentage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $totalPricing = 0;
                $totalPaid = 0;

                if (($attributes['billing_mode'] ?? 'by_case') === 'by_case') {
                    // MODO 1: COBRO GLOBAL POR CASO
                    $totalPricing = (float) $attributes['total_pricing'];
                    // Sumamos SOLO los pagos con estatus PAID
                    $totalPaid = (float) $this->payments()->where('payment_status', PaymentStatus::Paid)->sum('amount');
                } else {
                    // MODO 2: COBRO POR TRÁMITES (Sumamos la info de todos sus trámites)
                    foreach ($this->procedures as $procedure) {
                        // El costo total del trámite es la suma de TODOS sus pagos (pendientes + pagados)
                        $totalPricing += (float) $procedure->payments()->sum('amount');
                        // Lo pagado es solo lo que tiene estatus PAID
                        $totalPaid += (float) $procedure->payments()->where('payment_status', PaymentStatus::Paid)->sum('amount');
                    }
                }

                if ($totalPricing <= 0) return 0;
                return round(($totalPaid / $totalPricing) * 100, 2);
            },
        );
    }

    protected function remainingBalance(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $totalPricing = 0;
                $totalPaid = 0;

                if (($attributes['billing_mode'] ?? 'by_case') === 'by_case') {
                    $totalPricing = (float) $attributes['total_pricing'];
                    $totalPaid = (float) $this->payments()->where('payment_status', PaymentStatus::Paid)->sum('amount');
                } else {
                    foreach ($this->procedures as $procedure) {
                        $totalPricing += (float) $procedure->payments()->sum('amount');
                        $totalPaid += (float) $procedure->payments()->where('payment_status', PaymentStatus::Paid)->sum('amount');
                    }
                }

                return max(0, $totalPricing - $totalPaid);
            },
        );
    }

    // --- RELACIONES ---

    public function client()
    {
        return $this->belongsTo(Client::class, "client_id");
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class, "case_id");
    }

    public function payments()
    {
        // Esta relación es crucial para el cálculo del porcentaje
        // Debe apuntar a la tabla de pagos y usar el morphMany correcto.
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_lawyer');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
