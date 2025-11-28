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
        Schema::create('procedure_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("procedure_id")->index();
            $table->string("name");
            $table->string("file_path");
            $table->longText("notes")->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign("procedure_id")->references("id")->on("procedures")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_documents');
    }
};
