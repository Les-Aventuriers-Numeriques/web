<?php

namespace App\Models;

use Database\Factories\VoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Overtrue\LaravelVote\Vote as BaseVote;

class Vote extends BaseVote
{
    /** @use HasFactory<VoteFactory> */
    use HasFactory;
}
