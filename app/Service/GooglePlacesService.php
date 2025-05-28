<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

use function Hyperf\Support\env;

class GooglePlacesService
{
    protected Client $client;

    protected string $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/place/']);
        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function findBars(): array
    {
        $queryParams = [
            'query' => 'bares em Belo Horizonte MG',
            'type' => 'bar',
            'language' => 'pt-BR',
            'region' => 'br',
            'key' => $this->apiKey,
        ];

        try {
            $response = $this->client->get('textsearch/json', [
                'query' => $queryParams,
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if (! isset($data['results'])) {
                throw new RuntimeException('Resposta inválida da API do Google Places.');
            }

            return $data['results'];
        } catch (GuzzleException $e) {
            throw new RuntimeException('Erro ao acessar a API do Google Places: ' . $e->getMessage());
        }
    }

    public function rankBars(array $bars): array
    {
        if (empty($bars)) {
            return [];
        }

        $maxReviews = max(array_column($bars, 'user_ratings_total'));

        foreach ($bars as &$bar) {
            $rating = $bar['rating'] ?? 0;
            $reviews = $bar['user_ratings_total'] ?? 0;

            $reviewRatio = $maxReviews > 0 ? $reviews / $maxReviews : 0;
            $penalty = $reviewRatio > 0 ? min(0.5, log10(1 / $reviewRatio)) : 0.5;
            $score = $rating * (1 - $penalty) + ($reviewRatio * 2);

            $bar['score'] = round($score, 4);
        }
        unset($bar);

        usort($bars, fn($a, $b) => $b['score'] <=> $a['score']);

        $ranked = [];

        foreach ($bars as $index => $bar) {
            $ranked[] = [
                'position' => $index + 1,
                'name' => $bar['name'] ?? 'Unnamed',
                'score' => $bar['score'],
                'rating' => $bar['rating'] ?? null,
                'reviews' => $bar['user_ratings_total'] ?? 0,
            ];
        }

        return $ranked;
    }
}
