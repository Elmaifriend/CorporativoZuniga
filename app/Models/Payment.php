<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'payment_metod',
        'concept',
        'transaction_reference',
        'paymentable_id',
        'paymentable_type',
    ];


    public function paymentable(){
        return $this->morphTo();
    }

    public function client(){
        return $this->belongsTo(Client::class, "client_id");
    }
}