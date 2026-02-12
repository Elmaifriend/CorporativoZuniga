<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientCase;


class Appointments extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentsFactory> */
    use HasFactory;

    protected $fillable = [
        "appointmentable_id",
        "appointmentable_type",
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

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_lawyer');
    }

    public function case()
    {
        return $this->belongsTo(ClientCase::class, 'case_id');
    }
}