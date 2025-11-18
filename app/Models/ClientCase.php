<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCase extends Model
{
    /** @use HasFactory<\Database\Factories\ClientCaseFactory> */
    use HasFactory;

    protected $fillable = [
        "client_id",
        "case_name",
        "resposable_lawyer",
        "case_type",
        "juzgado", //Traducir
        "external_expedient_number",
        "resume",
        "start_date",
        "stimated_finish_date",
        "real_finish_date",
        "status",
        "total_pricing",
        "paid_porcentage" //convertir en un computed field
    ];

    public function client(){
        return $this->belongsTo(Client::class, "client_id");
    }

    public function procedures(){
        return $this->hasMany(Procedure::class, "case_id");
    }

    public function payments(){
        return $this->morphMany(Payment::class, "paymentable");
    }
}