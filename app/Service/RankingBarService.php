<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use App\Model\Bar;

class RankingBarService
{
    public function rankBars(array $bars): array
    {
        if (empty($bars)) {
            return [];
        }
        /** @var Bar $bar */
        foreach ($bars as &$bar) {
            $bar = $bar->toArray();

            $rating = (float) $bar['rating'] ?? 0;
            $reviews = $bar['reviews'] ?? 0;

            // Elo invertido: quanto mais review, menor peso por review

            $score = $this->calculateScore($rating, $reviews);

            $bar['score'] = round($score, 4);
        }

        unset($bar);

        // Ordena decrescente por score
        usort($bars, fn ($a, $b) => $b['score'] <=> $a['score']);

        // Aplica posições
        $ranked = [];
        foreach ($bars as $index => $bar) {
            $ranked[] = [
                'id' => $bar['id'],
                'position' => $index + 1,
                'name' => $bar['name'] ?? 'Unnamed',
                'score' => $bar['score'],
                'rating' => $bar['rating'] ?? null,
                'reviews' => $bar['user_ratings_total'] ?? 0,
                'place_id' => $bar['place_id'] ?? null,
            ];
        }

        return $ranked;
    }

    private function calculateScore(float $rating, int $reviews): float
    {
        if ($reviews <= 0 || $rating <= 0) {
            return 0.0;
        }

        return $rating * log10(1 + (1000 / $reviews));
    }
}
