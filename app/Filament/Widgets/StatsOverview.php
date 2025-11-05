<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\Counselors\CounselorResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Galleries\GalleryResource;
use App\Filament\Resources\Provinces\ProvinceResource;
use App\Filament\Resources\Regencies\RegencyResource;
use App\Models\Article;
use App\Models\Counselor;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Province;
use App\Models\Regency;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Terapis'), Counselor::count())
                ->icon('heroicon-o-users')
                ->color('success')
                ->url(CounselorResource::getUrl('index')),
            Stat::make(__('Gallery'), Gallery::count())
                ->icon('heroicon-o-photo')
                ->color('danger')
                ->url(GalleryResource::getUrl('index')),
            Stat::make(__('Articles'), Article::count())
                ->icon('heroicon-o-document')
                ->color('danger')
                ->url(ArticleResource::getUrl('index')),
            Stat::make(__('Events'), Event::count())
                ->icon('heroicon-o-calendar')
                ->color('warning')
                ->url(EventResource::getUrl('index')),
            Stat::make(__('Provinces'), Province::count())
                ->icon('heroicon-o-map')
                ->color('primary')
                ->url(ProvinceResource::getUrl('index')),
            Stat::make(__('Regencies'), Regency::count())
                ->icon('heroicon-o-map')
                ->color('primary')
                ->url(RegencyResource::getUrl('index')),
        ];
    }
}
