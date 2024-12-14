<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Two\User as DiscordUser;

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

    public function resetRoles(): self
    {
        $this->is_member = $this->is_lan_participant = $this->is_admin = false;

        return $this;
    }

    public function syncWithDiscord(DiscordUser $discordUser, object $membershipInfo, object $roles): self
    {
        $userInfo = data_get($membershipInfo, 'user');

        $this->display_name = data_get($membershipInfo, 'nick') ?? $discordUser->getNickname();

        $memberAvatarHash = data_get($membershipInfo, 'avatar');
        $userAvatarHash = data_get($userInfo, 'avatar');

        if ($memberAvatarHash) {
            $guildId = Config::integer('services.discord.guild_id');

            $this->avatar_url = "https://cdn.discordapp.com/guilds/$guildId/users/{$discordUser->getId()}/avatars/$memberAvatarHash.png";
        } elseif ($userAvatarHash) {
            $this->avatar_url = $discordUser->getAvatar();
        }

        $this->is_member = data_get($roles, 'isMember', false);
        $this->is_lan_participant = data_get($roles, 'isLanParticipant', false);
        $this->is_admin = data_get($roles, 'isAdmin', false);
        $this->must_relogin = false;

        return $this;
    }

    public static function determineRoles(object $membershipInfo): object
    {
        $roles = data_get($membershipInfo, 'roles', []);

        $isMember = in_array(Config::integer('services.discord.member_role_id'), $roles);
        $isLanParticipant = in_array(Config::integer('services.discord.member_role_id'), $roles);
        $isAdmin = in_array(Config::integer('services.discord.member_role_id'), $roles);
        $hasAnyRole = $isMember || $isLanParticipant || $isAdmin;

        return (object) compact('isMember', 'isLanParticipant', 'isAdmin', 'hasAnyRole');
    }
}
