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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text("body");
            $table->unsignedBigInteger("writed_by");
            $table->unsignedBigInteger("assigned_to")->nullable();
            $table->string("status")->nullable(); //Pendiente, resuelto
            $table->string("attended_by")->nullable();
            $table->dateTime("solved_date")->nullable();
            $table->morphs("commentable");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
