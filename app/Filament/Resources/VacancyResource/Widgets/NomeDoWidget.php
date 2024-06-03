<?php

namespace App\Filament\Resources\VacancyResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;

class NomeDoWidget extends Widget
{
    protected static string $view = 'filament.resources.vacancy-resource.widgets.nome-do-widget';

    protected function getViewData(): array
    {
        return [
            'name' => 'Fabio'
        ];
    }
}
