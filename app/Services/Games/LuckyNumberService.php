<?php

namespace App\Services\Games;

use App\Models\Result;

class LuckyNumberService extends GameService
{
    protected function getGameType(): string
    {
        return 'LuckyNumber';
    }

    public function calculateResult(): array
    {
        return $this->getResultArray();
    }

    private function getResultArray(): array
    {
        $resultNumber = rand(1, 1000);
        $result = "Lose";
        $winAmount = 0;

        if ($resultNumber % 2 === 0) {
            $result = "Win";
            $winAmount = $this->calculateWinAmount($resultNumber);
        }

        return [
            'result_number' => $resultNumber,
            'result' => $result,
            'win_amount' => $winAmount
        ];
    }

    private function calculateWinAmount(int $resultNumber): int
    {
        if ($resultNumber > 900) {
            return (int)($resultNumber * 0.7);
        }

        if ($resultNumber > 600) {
            return (int)($resultNumber * 0.5);
        }

        if ($resultNumber > 300) {
            return (int)($resultNumber * 0.3);
        }

        return (int)($resultNumber * 0.1);
    }
}
