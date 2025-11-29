<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    /**
     * Relación polimórfica al modelo que recibe el comentario.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Usuario que escribió el comentario.
     */
    public function writedBy()
    {
        return $this->belongsTo(User::class, 'writed_by');
    }

    /**
     * Usuario asignado para atender el comentario.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Usuario que atendió y resolvió el comentario.
     */
    public function attendedBy()
    {
        return $this->belongsTo(User::class, 'attended_by');
    }

    /**
     * Verifica si el comentario está resuelto.
     */
    public function isResolved(): bool
    {
        return $this->status === 'Resuelto';
    }
}
