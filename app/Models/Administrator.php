<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpKernel\Profiler\Profile;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_secret'
    ];
    protected $casts = [
        'api_secret' => 'string'
    ];

    /**
     * Return all approved comments from current admin
     * @return HasMany
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Return all created profile from current admin
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
