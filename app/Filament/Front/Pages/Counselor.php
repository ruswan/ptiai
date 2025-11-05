<?php

namespace App\Filament\Front\Pages;

use App\Filament\Front\Widgets\FrontCounselorTable;
use Filament\Pages\Page;

class Counselor extends Page
{
    protected string $view = 'filament.front.pages.counselor';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Direktori Terapis';

    protected function getHeaderWidgets(): array
    {
        return [
            FrontCounselorTable::class,
        ];
    }
}
