<?php

namespace App\Http\Controllers\Hub;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordInteractionServiceContract;

class DiscordInteraction extends Controller
{
    public function __invoke(Request $request, DiscordInteractionServiceContract $discordInteractionService): JsonResponse
    {
        $response = $discordInteractionService->handleInteractionRequest($request);

        return response()->json($response->toArray(), $response->getStatus());
    }
}
