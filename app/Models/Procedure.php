<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Procedure extends Model
{
    /** @use HasFactory<\Database\Factories\ProcedureFactory> */
    use HasFactory;

    protected $fillable = [
        "case_id",
        "title",
        "responsable_employee",
        "status",
        "starting_date",
        "last_update",
        "finish_date",
        "limit_date",
        "priority",
        "order",
        "installments",
        "installment_interval",
    ];

    protected $casts = [
        'starting_date' => 'datetime',
        'last_update' => 'datetime',
        'finish_date' => 'datetime',
        'limit_date' => 'datetime',
        'order' => 'integer',
    ];

    public function clientCase()
    {
        return $this->belongsTo(ClientCase::class, "case_id");
    }

    public function documents()
    {
        return $this->hasMany(ProcedureDocument::class, "procedure_id");
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
}
