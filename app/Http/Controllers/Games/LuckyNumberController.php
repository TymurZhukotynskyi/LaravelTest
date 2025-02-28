<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Repositories\Games\LinkRepository;
use App\Repositories\Games\ResultRepository;
use App\Services\Games\LuckyNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LuckyNumberController extends Controller
{

    private LinkRepository $linkRepository;

    private ResultRepository $resultRepository;

    private LuckyNumberService $luckyNumberService;

    public function __construct(
        LinkRepository $linkRepository,
        LuckyNumberService $luckyNumberService,
        ResultRepository $resultRepository
    )
    {
        $this->linkRepository = $linkRepository;
        $this->luckyNumberService = $luckyNumberService;
        $this->resultRepository = $resultRepository;
    }

    public function gamePage(string $uniqueLink)
    {
        $link = Cache::get("link_{$uniqueLink}");

        return view('games.lucky_number.index', [
            'link' => $link
        ]);
    }

    public function generateNewLink(string $uniqueLink)
    {
        $oldLink = Cache::get("link_{$uniqueLink}");

        $activeLink = $this->luckyNumberService->generateLink($oldLink->user);
        if ($activeLink instanceof Link) {
            $oldLink = $this->linkRepository->disableLink($oldLink);
            Cache::forget("link_{$oldLink->unique_link}");
        }

        return view('games.lucky_number.index', [
            'link' => $activeLink,
            'isNewLink' => true
        ]);
    }

    public function deactivateLink(string $uniqueLink)
    {
        $oldLink = Cache::get("link_{$uniqueLink}");

        $oldLink = $this->linkRepository->disableLink($oldLink);
        Cache::forget("link_{$oldLink->unique_link}");

        return view('games.lucky_number.index', [
            'link' => $oldLink,
            'linkDeactivated' => true
        ]);
    }

    public function play(string $uniqueLink)
    {
        $link = Cache::get("link_{$uniqueLink}");

        $calculatedResult = $this->luckyNumberService->calculateResult();

        $result = $this->resultRepository->createResult(
            $link->user_id,
            $link->id,
            $link->game_type,
            $calculatedResult['result_number'],
            $calculatedResult['result'],
            $calculatedResult['win_amount']
        );

        Cache::forget("LuckyNumber_{$link->id}_last_results");

        return view('games.lucky_number.index', [
            'link' => $link,
            'result' => $result
        ]);
    }

    protected function showHistory(string $uniqueLink)
    {
        $link = Cache::get("link_{$uniqueLink}");

        $historyResults = $this->resultRepository->getLastResults($link->id, 3);

        return view('games.lucky_number.index', [
            'link' => $link,
            'historyResults' => $historyResults
        ]);
    }
}
