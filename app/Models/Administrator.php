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
        'id','api_secret','bearer_token'
    ];
    protected $casts = [
        'id' => 'integer',
        'api_secret' => 'string',
        'bearer_token' => 'string'
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

    public function hasComment($profileId): bool
    {
        return Comment::where([
            ['administrator_id', $this->id],
            ['profil_id', $profileId]
            ])->count() > 0;
    }
}
