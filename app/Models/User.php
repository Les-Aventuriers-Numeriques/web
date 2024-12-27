<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Two\User as DiscordUser;
use Overtrue\LaravelVote\Traits\Voter;
use Overtrue\LaravelVote\Vote;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Voter;

    /**
     * @var bool
     */
    public $incrementing = false;

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
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
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

    public function updateFromDiscord(DiscordUser $discordUser, object $membershipInfo): self
    {
        $userInfo = data_get($membershipInfo, 'user');

        $this->display_name = data_get($membershipInfo, 'nick') ?: $discordUser->getNickname();

        $memberAvatarHash = data_get($membershipInfo, 'avatar');
        $userAvatarHash = data_get($userInfo, 'avatar');

        if ($memberAvatarHash) {
            $guildId = Config::integer('services.discord.guild_id');

            $this->avatar_url = "https://cdn.discordapp.com/guilds/$guildId/users/{$discordUser->getId()}/avatars/$memberAvatarHash.png";
        } elseif ($userAvatarHash) {
            $this->avatar_url = $discordUser->getAvatar();
        }

        $roles = data_get($membershipInfo, 'roles', []);

        $this->is_member = in_array(Config::integer('services.discord.roles_id.member'), $roles);
        $this->is_lan_participant = in_array(Config::integer('services.discord.roles_id.lan_participant'), $roles);
        $this->is_admin = in_array(Config::integer('services.discord.roles_id.admin'), $roles);
        $this->must_relogin = false;

        return $this;
    }

    public function voteYes(GameProposal $votable): Vote
    {
        return $this->vote($votable, 2);
    }

    public function voteMaybe(GameProposal $votable): Vote
    {
        return $this->vote($votable, 1);
    }

    public function voteNo(GameProposal $votable): Vote
    {
        return $this->vote($votable, -1);
    }

    /**
     * @return HasMany<GameProposal, User>
     */
    public function gameProposals(): HasMany
    {
        return $this->hasMany(GameProposal::class);
    }
}
