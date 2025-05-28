<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Bar;

class BarRepository
{
    public function saveOrUpdateFromGoogle(array $data): Bar
    {
        return Bar::updateOrCreate(
            ['place_id' => $data['place_id']],
            [
                'name' => $data['name'] ?? 'Sem Nome',
                'address' => $data['formatted_address'] ?? null,
                'latitude' => $data['geometry']['location']['lat'] ?? null,
                'longitude' => $data['geometry']['location']['lng'] ?? null,
                'rating' => $data['rating'] ?? 0.0,
                'reviews' => $data['user_ratings_total'] ?? 0,
            ]
        );
    }

    public function getTopBarsByDate(string $date, int $limit = 20): array
    {
        return Bar::whereHas('rankings', fn ($query) => $query->where('snapshot_date', $date))
            ->with(['rankings' => fn ($query) => $query->where('snapshot_date', $date)])
            ->orderByDesc('rankings.score')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
