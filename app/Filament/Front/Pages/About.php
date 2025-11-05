<?php

namespace App\Filament\Front\Pages;

use Filament\Pages\Page;

class About extends Page
{
    protected string $view = 'filament.front.pages.about';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Tentang PTIAI';
}
