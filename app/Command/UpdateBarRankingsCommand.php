<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\BarRankingRepository;
use App\Repository\BarRepository;
use App\Service\DivisionService;
use App\Service\GooglePlacesService;
use App\Service\RankingBarService;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Throwable;
use function Hyperf\Support\now;

#[Command]
class UpdateBarRankingsCommand extends HyperfCommand
{
    #[Inject]
    protected GooglePlacesService $googlePlacesService;

    #[Inject]
    protected RankingBarService $rankingService;

    #[Inject]
    protected DivisionService $divisionService;

    #[Inject]
    protected BarRepository $barRepository;

    #[Inject]
    protected BarRankingRepository $rankingRepository;

    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('ranking:update');
    }

    public function configure()
    {
        $this->setDescription('📊 Atualiza os rankings e divisões dos bares');
    }

    public function handle()
    {
        $this->line('🏁 Iniciando atualização de ranking dos bares...', 'info');

        try {
            $rawBars = $this->googlePlacesService->findBars();
            $this->line('📦 Dados brutos carregados da API.', 'info');

            $bars = [];
            foreach ($rawBars as $rawBar) {
                $bars[] = $this->barRepository->saveOrUpdateFromGoogle($rawBar);
            }

            $latestSnapshotDate = $this->rankingRepository->getLatestSnapshotDate();
            $historicalData = $this->rankingRepository->getRankingsBySnapshot($latestSnapshotDate);

            $rankedBars = $this->rankingService->rankBars($bars);
            $rankedBars = $this->divisionService->applyDivisions($rankedBars, $historicalData);
            $this->line('📈 Bares ranqueados e divisões aplicadas.', 'info');

            $this->rankingRepository->saveRanking($rankedBars);

            $this->line('🏆 Rankings salvos com sucesso!', 'info');
        } catch (Throwable $e) {
            $this->line('❌ Erro durante a atualização: ' . $e->getMessage(), 'error');
            $this->line('📅 Data do erro: ' . now()->toDateTimeString(), 'comment');
        }
    }
}