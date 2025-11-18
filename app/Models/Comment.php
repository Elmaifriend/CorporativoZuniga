<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    
    protected $fillable = [
        "body",
        "writed_by",
        "assigned_to",
        "status",
        "attended_by",
        "solved_date",
    ];
}
