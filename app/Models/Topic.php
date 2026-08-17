<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    /** @use HasFactory<\Database\Factories\TopicFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'category', 'description', 'is_sensitive'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_topic')
                    ->withPivot('experience_level')
                    ->withTimestamps();
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
