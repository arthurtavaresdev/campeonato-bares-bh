<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\BarRanking;
use Psr\Http\Message\ResponseInterface;

class RankingController extends AbstractController
{
    public function index(): ResponseInterface
    {
        // Busca a última data de snapshot registrada
        $latestDate = BarRanking::query()->max('snapshot_date');

        if (! $latestDate) {
            return $this->response->json(['message' => 'No ranking data available'])->withStatus(404);
        }

        $latestDate = \Carbon\Carbon::parse($latestDate)->startOfDay();

        // Busca os bares com ranking mais recente
        $rankings = BarRanking::query()
            ->with('bar')
            ->whereDate('snapshot_date', $latestDate)
            ->orderBy('position')
            ->get();

        return $this->response->json([
            'date' => $latestDate?->toDateString() ?? null,
            'ranking' => $rankings,
        ]);
    }
}
