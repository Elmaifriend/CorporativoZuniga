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
        Schema::create('client_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("client_id")->index();
            $table->string("case_name")->index();
            $table->string("responsable_lawyer");
            $table->string("case_type")->index();
            $table->string("courtroom"); //Traducir a ingles
            $table->string("external_expedient_number")->index();
            $table->longText("resume");
            $table->DateTime("start_date");
            $table->DateTime("stimated_finish_date");
            $table->DateTime("real_finished_date");
            $table->string("status")->index(); 
            $table->string("total_pricing"); //Traducir a ingles ( honorarios? )
            $table->string("paid_porcentage"); //Pasar a computed field <==== IMPORTANTE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_cases');
    }
};
