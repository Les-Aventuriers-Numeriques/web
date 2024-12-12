<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'display_name',
        'avatar_url',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'must_relogin' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'display_name' => 'string',
            'avatar_url' => 'string',
            'must_relogin' => 'boolean',
        ];
    }
}
