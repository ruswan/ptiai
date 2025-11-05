<?php

namespace App\Providers\Filament;

use App\Filament\Front\Pages\Home;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class FrontPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('front')
            ->path('/')
            ->topNavigation()
            ->colors([
                'primary' => '#6e2d91',
            ])
            ->brandLogo('/images/logo-ptiai.png')
            ->brandLogoHeight('50px')
            ->darkMode(false)
            ->spa()
            ->discoverResources(in: app_path('Filament/Front/Resources'), for: 'App\Filament\Front\Resources')
            ->discoverPages(in: app_path('Filament/Front/Pages'), for: 'App\Filament\Front\Pages')
            ->pages([
                Home::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Front/Widgets'), for: 'App\Filament\Front\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([])
            ->viteTheme('resources/css/filament/front/theme.css')
            ->renderHook(PanelsRenderHook::HEAD_START, fn () => view('partials.meta-head'))
            ->renderHook(PanelsRenderHook::TOPBAR_AFTER, fn () => request()->is('/') ? view('partials.front-header') : '')
            ->renderHook(PanelsRenderHook::TOPBAR_AFTER, fn () => request()->is('/') ? view('partials.front-stat-overview') : '')
            ->renderHook(PanelsRenderHook::BODY_END, fn () => request()->is('/') ? view('partials.article-section') : '')
            ->renderHook(PanelsRenderHook::BODY_END, fn () => request()->is('/') ? view('partials.event-section') : '')
            ->renderHook(PanelsRenderHook::BODY_END, fn () => view('partials.front-footer'))
            ->renderHook(
                PanelsRenderHook::TOPBAR_AFTER,
                function () {
                    return match (true) {
                        request()->is('about') => view('partials.jumbotron', ['title' => 'Tentang PTIAI']),
                        request()->is('terapis') => view('partials.jumbotron', ['title' => 'Direktori Terapis']),
                        request()->is('article') => view('partials.jumbotron', ['title' => 'Artikel']),
                        request()->is('article/*') => (function () {
                            $record = request()->route('slug');
                            $record = \App\Models\Article::where('slug', $record)->first();
                            $title = $record ? $record->title : 'Detail Artikel';

                            return view('partials.jumbotron', ['title' => $title]);
                        })(),
                        request()->is('event') => view('partials.jumbotron', ['title' => 'Event']),
                        request()->is('event/*') => (function () {
                            $record = request()->route('slug');
                            $record = \App\Models\Event::where('slug', $record)->first();
                            $title = $record ? $record->name : 'Detail Event';

                            return view('partials.jumbotron', ['title' => $title]);
                        })(),
                        request()->is('gallery') => view('partials.jumbotron', ['title' => 'Galeri Kegiatan']),
                        request()->is('galeri/*') => (function () {
                            $record = request()->route('slug');
                            $record = \App\Models\Gallery::where('slug', $record)->first();
                            $title = $record ? $record->title : 'Detail Galeri';

                            return view('partials.jumbotron', ['title' => $title]);
                        })(),
                        default => ''
                    };
                }
            );
    }
}
