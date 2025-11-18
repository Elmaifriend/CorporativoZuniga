<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurrent_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("client_id")->index();
            $table->string("title");
            $table->longText("description");
            $table->double("amount");
            $table->string("frequency"); //semana, mensual, bimestral, trimestral
            $table->integer("agreed_payment_day");
            $table->dateTime("contract_start_date");
            $table->string("status"); //Activa, en mora, finalizado, cancelado
            $table->string("expiration_alert");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrent_payments');
    }
};
