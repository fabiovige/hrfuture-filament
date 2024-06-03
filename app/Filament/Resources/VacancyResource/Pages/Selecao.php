<?php

namespace App\Filament\Resources\VacancyResource\Pages;

use App\Filament\Resources\VacancyResource;
use App\Filament\Resources\VacancyResource\Widgets\NomeDoWidget;
use App\Filament\Resources\VacancyResource\Widgets\VacancyChart;
use App\Filament\Resources\VacancyResource\Widgets\VacancyPie;
use App\Filament\Resources\VacancyResource\Widgets\VacancyStatsOverview;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class Selecao extends Page
{
    use InteractsWithRecord;


    protected static string $resource = VacancyResource::class;

    protected static string $view = 'filament.pages.vacancy.selecao';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function viewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VacancyStatsOverview::class,
            VacancyChart::class,
            VacancyPie::class
        ];
    }
}
