<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\BarRanking;
use Carbon\Carbon;

class BarRankingRepository
{
    public function saveRanking(array $bars, ?Carbon $snapshotDate = null): void
    {
        $snapshotDate = ($snapshotDate ?? Carbon::today())->startOfDay();

        foreach ($bars as $bar) {
            BarRanking::updateOrCreate(
                [
                    'bar_id' => $bar['id'],
                    'snapshot_date' => $snapshotDate,
                ],
                [
                    'position' => $bar['position'],
                    'score' => $bar['score'],
                    'division' => $bar['division'],
                    'strikes' => $bar['strikes'],
                ]
            );
        }
    }

    public function getLatestSnapshotDate(): ?Carbon
    {
        $maxDate = BarRanking::max('snapshot_date');
        return $maxDate ? Carbon::parse($maxDate) : null;
    }

    public function getRankingsBySnapshot(?Carbon $date): array
    {
        if (! $date) {
            return [];
        }

        return BarRanking::whereDate('snapshot_date', $date)
            ->with('bar')
            ->get()
            ->map(function ($ranking) {
                return [
                    'bar_id' => $ranking->bar_id,
                    'position' => $ranking->position,
                    'score' => $ranking->score,
                    'name' => $ranking->bar->name ?? null,
                    'place_id' => $ranking->bar->place_id ?? null,
                ];
            })->toArray();
    }
}
