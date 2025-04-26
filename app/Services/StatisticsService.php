<?php

namespace App\Services;

use App\Repositories\StatisticsRepository;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    protected $statisticsRepository;

    public function __construct(StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getDashboardStatistics()
    {
        return [
            'users_count' => $this->statisticsRepository->getUsersCount(),
            'categories_count' => $this->statisticsRepository->getCategoriesCount(),
            'restaurants_count' => $this->statisticsRepository->getRestaurantsCount()
        ];
    }
} 