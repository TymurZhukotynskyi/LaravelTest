<?php

namespace App\Repositories\Games;

use App\Models\Link;
use Carbon\Carbon;

class LinkRepository
{

    public function findActiveLinkByUserId(int $userId): ?Link
    {
        return Link::where('user_id', $userId)
            ->where('is_active', true)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    public function checkUniqueLinkAlreadyExists(string $uniqueLink): bool
    {
        return Link::where('unique_link', $uniqueLink)
            ->exists();
    }

    public function findActiveLinkByUniqueLink(string $uniqueLink): ?Link
    {
        return Link::where('unique_link', $uniqueLink)
            ->where('is_active', true)
            ->first();
    }

    public function disableLink(Link $link): Link
    {
        $link->is_active = false;
        $link->save();

        return $link;
    }

    public function createLink(int $userId, string $uniqueLink, string $gameType, Carbon $expiresAt, bool $isActive = true): Link
    {
        return Link::create([
            'user_id' => $userId,
            'unique_link' => $uniqueLink,
            'game_type' => $gameType,
            'expires_at' => $expiresAt,
            'is_active' => $isActive,
        ]);
    }
}
