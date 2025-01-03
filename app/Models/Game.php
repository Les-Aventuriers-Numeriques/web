<?php

namespace App\Models;

use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /** @use HasFactory<GameFactory> */
    use HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'custom_url',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'custom_url' => null,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'custom_url' => 'string',
        ];
    }

    public function getIsCustomAttribute(): bool
    {
        return $this->id < 0;
    }

    public function getUrlAttribute(): string
    {
        return $this->custom_url ?: "https://store.steampowered.com/app/$this->id";
    }

    public function getImageUrlAttribute(): string
    {
        return $this->is_custom
            ? asset("images/games/$this->id.png")
            : "https://cdn.cloudflare.steamstatic.com/steam/apps/$this->id/capsule_231x87.jpg";
    }

    /**
     * @return HasMany<GameProposal, $this>
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(GameProposal::class);
    }
}
