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

namespace App\Controller;

use App\Service\DivisionService;
use App\Service\GooglePlacesService;
use App\Service\RankingBarService;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->response->json([
            'message' => 'OK',
        ]);
    }
}
