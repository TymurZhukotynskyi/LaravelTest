<?php

namespace App\Repositories\Games;

use App\Models\Result;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ResultRepository
{
    public function createResult(int $userId, int $linkId, string $gameType, int $resultNumber, string $result, float $winAmount): Result
    {
        return Result::create([
            'user_id' => $userId,
            'link_id' => $linkId,
            'game_type' => $gameType,
            'result_number' => $resultNumber,
            'result' => $result,
            'win_amount' => $winAmount,
        ]);
    }

    public function getLastResults(int $linkId, int $limit): Collection
    {
        return Cache::remember("LuckyNumber_{$linkId}_last_results", 60000, function () use ($linkId, $limit) {
            return Result::query()
                ->where('link_id', $linkId)
                ->orderBy('id', 'desc')
                ->take($limit)
                ->get();
        });
    }
}
