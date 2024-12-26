<?php

namespace App\Models;

use Database\Factories\GameProposalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Overtrue\LaravelVote\Traits\Votable;

class GameProposal extends Model
{
    /** @use HasFactory<GameProposalFactory> */
    use HasFactory, Votable;

    /**
     * @var string
     */
    protected $primaryKey = 'game_id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'game_id',
        'user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'game_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, GameProposal>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Game, GameProposal>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
