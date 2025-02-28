<?php

namespace App\Services\Games;

use App\Models\Result;
use App\Models\User;
use App\Models\Link;
use App\Repositories\Games\LinkRepository;
use App\Repositories\Games\ResultRepository;
use Illuminate\Support\Str;

abstract class GameService
{
    protected string $name;

    protected LinkRepository $linkRepository;

    public function __construct(
        LinkRepository $linkRepository
    )
    {
        $this->name = $this->getGameType();
        $this->linkRepository = $linkRepository;
    }

    abstract protected function getGameType(): string;

    abstract public function calculateResult(): array;

    private function getUniqueLink(): string
    {
        do {
            $uniqueLink = Str::random(24);
            $checkFlag = $this->linkRepository->checkUniqueLinkAlreadyExists($uniqueLink);
        } while ($checkFlag);

        return $uniqueLink;
    }

    public function generateLink(User $user): Link
    {
        return $activeLink = $this->linkRepository->createLink(
            $user->id,
            $this->getUniqueLink(),
            $this->name,
            \Carbon\Carbon::now()->addDays(7),
            true
        );

    }

    public function getActiveLink(User $user): string
    {
        $activeLink = $this->linkRepository->findActiveLinkByUserId($user->id);

        if (!$activeLink) {
            $activeLink = $this->generateLink($user);
        }

        return $activeLink->getFullLinkToGamePage();
    }
}
