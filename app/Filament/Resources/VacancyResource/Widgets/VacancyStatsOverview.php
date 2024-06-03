<?php

namespace App\Filament\Resources\VacancyResource\Widgets;

use Filament\Infolists\Components\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VacancyStatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.widgets.vacancy-stat';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Candidatos', 123),
            Stat::make('Total Vagas', 456),
            Stat::make('Percentual', '75%'),
        ];
    }
}
