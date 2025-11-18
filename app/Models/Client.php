<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        "full_name",
        "person_type",
        "phone_number",
        "email",
        "curp",
        "rfc",
        "address",
        "occupation",
        "date_of_birth",
    ];

    public function appointments(){
        return $this->morphMany(Appointments::class, "appointmentable");
    }

    public function payments(){
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function cases(){
        return $this->hasMany(ClientCase::class, "client_id");
    }

    public function documents(){
        return $this->hasMany(ClientDocument::class, "client_id");
    }

    public function recurrentPayments(){
        return $this->hasMany(RecurrentPayment::class, "client_id");
    }
}