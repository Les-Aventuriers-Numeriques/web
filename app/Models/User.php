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
        'is_member',
        'is_lan_participant',
        'is_admin',
        'must_relogin',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_member' => false,
        'is_lan_participant' => false,
        'is_admin' => false,
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
            'is_member' => 'boolean',
            'is_lan_participant' => 'boolean',
            'is_admin' => 'boolean',
            'must_relogin' => 'boolean',
        ];
    }
}
