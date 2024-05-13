<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'administrator_id', 'profil_id'
    ];

    protected $casts = [
        'content' => 'string',
        'administator_id' => 'integer',
        'profil_id' => 'integer'
    ];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
