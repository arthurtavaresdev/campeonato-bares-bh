<?php

declare(strict_types=1);

namespace App\Service;

class DivisionService
{
    private const TOP_LIMIT = 20;

    private const MAX_ABSENCES = 3;

    /**
     * Aplica as divisões (Série A ou B) com base na posição e histórico de presença.
     *
     * @param array $rankedBars Lista de bares ranqueados com posição e score
     * @param array $historicalData Histórico de presença no top 20 (pode ser buscado do banco futuramente)
     *
     * @return array Lista com a chave "division" atribuída a cada bar
     */
    public function applyDivisions(array $rankedBars, array $historicalData = []): array
    {
        $updatedBars = [];

        foreach ($rankedBars as $index => $bar) {
            $placeId = $bar['place_id'];
            $position = $bar['position'];

            $strikes = $historicalData[$placeId]['strikes'] ?? 0;
            $previousDivision = $historicalData[$placeId]['division'] ?? 'A';

            if ($position <= self::TOP_LIMIT) {
                // Dentro do top 20: reseta os strikes e mantém na Série A
                $division = 'A';
                $strikes = 0;
            } else {
                // Fora do top 20: aumenta strikes
                ++$strikes;

                if ($strikes >= self::MAX_ABSENCES) {
                    $division = 'B';
                } else {
                    $division = $previousDivision;
                }
            }

            $updatedBars[] = array_merge($bar, [
                'division' => $division,
                'strikes' => $strikes,
            ]);
        }

        return $updatedBars;
    }
}
