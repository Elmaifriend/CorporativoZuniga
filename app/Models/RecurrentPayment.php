<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurrentPayment extends Model
{
    /** @use HasFactory<\Database\Factories\RecurrentPaymentFactory> */
    use HasFactory;

    protected $fillable = [
        "client_id",
        "title",
        "description",
        "amount",
        "frecuency",
        "agreed_payment_day",
        "contract_start_date",
        "status",
        "expiration_alert",
    ];
}