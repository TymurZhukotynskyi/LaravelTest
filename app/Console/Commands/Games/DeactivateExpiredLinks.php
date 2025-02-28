<?php

namespace App\Console\Commands\Games;

use Illuminate\Console\Command;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeactivateExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:deactivate-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate links that have expired based on their expires_at date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredLinkIds = Link::select('id', 'unique_link')
            ->where('is_active', true)
            ->whereBetween('expires_at', [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay()
            ])
            ->pluck('id')
            ->toArray();

        $count = count($expiredLinkIds);

        if ($count === 0) {
            $this->info('No links expiring today found.');
            return;
        }

        DB::statement(
            'UPDATE links SET is_active = 0 WHERE id IN (' . implode(',', array_fill(0, $count, '?')) . ')',
            $expiredLinkIds
        );

        $this->info("Successfully deactivated {$count} expired link(s).");
    }
}
