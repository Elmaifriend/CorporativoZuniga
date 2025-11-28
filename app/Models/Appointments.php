<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentsFactory> */
    use HasFactory;

    protected $fillable = [
        "date_time",
        "reason",
        "status",
        "case_id",
        "responsable_lawyer",
        "modality",
        "notes",
    ];

    public function appointmentable(){
        return $this->morphTo();
    }

    public function responsable(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_lawyer');
    }
}