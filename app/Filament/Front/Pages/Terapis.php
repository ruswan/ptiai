<?php

namespace App\Filament\Front\Pages;

use App\Filament\Front\Widgets\FrontCounselorTable;
use Filament\Pages\Page;

class Terapis extends Page
{
    protected string $view = 'filament.front.pages.terapis';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Direktori Terapis';

    protected function getHeaderWidgets(): array
    {
        return [
            FrontCounselorTable::class,
        ];
    }
}
