<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureDocument extends Model
{
    /** @use HasFactory<\Database\Factories\ProcedureDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        "procedure_id",
        "name",
        "file_path",
        "notes",
    ];

    public function procedure(){
        return $this->belongsTo(Procedure::class, "procedure_id");
    }
}


