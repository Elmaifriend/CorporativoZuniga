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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("case_id")->index();
            $table->string("title")->index();
            $table->string("responsable_employee")->nullable();
            $table->string("status");
            $table->dateTime("starting_date");
            $table->dateTime("last_update")->nullable();
            $table->dateTime("finish_date")->nullable();
            $table->dateTime("limit_date")->nullable();
            $table->string("priority");
            $table->integer("order");
            $table->string("notes")->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign("case_id")->references("id")->on("client_cases")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
