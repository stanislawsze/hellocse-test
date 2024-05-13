<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 'lastname', 'administrator_id', 'avatar', 'status'
    ];

    protected $casts = [
        'firstname' => 'string',
        'lastname' => 'string',
        'administrator_id' => 'integer',
        'avatar' => 'string',
        'status' => 'string'
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
