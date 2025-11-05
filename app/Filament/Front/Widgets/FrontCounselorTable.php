<?php

namespace App\Filament\Front\Widgets;

use App\Models\Counselor;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class FrontCounselorTable extends TableWidget
{
    protected string $view = 'filament.front.widgets.front-counselor-table';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->query(fn (): Builder => Counselor::query()->where('status_id', 1)->latest())
            ->columns([
                Split::make([
                    Stack::make([
                        ImageColumn::make('profile_photo')
                            ->label(__('Photo'))
                            ->disk('public')
                            ->alignCenter()
                            ->square()
                            ->imageSize(100, 100),
                    ]),
                    Stack::make([
                        TextColumn::make('user.name')
                            ->weight(FontWeight::ExtraBold)
                            ->searchable(),
                        TextColumn::make('registration_number')
                            ->extraAttributes(['class' => 'italic']),
                        TextColumn::make('regency.name'),
                    ]),

                ])->columnSpanFull(),
                Panel::make([
                    TextColumn::make('whatsapp_number')
                        ->icon(Phosphor::WhatsappLogo)
                        ->url(fn (Counselor $record): ?string => $record->whatsapp_number ? 'https://wa.me/'.preg_replace('/[^0-9]/', '', $record->whatsapp_number) : null)
                        ->openUrlInNewTab()
                        ->visible(fn (?Counselor $record): bool => $record && ! empty($record->whatsapp_number)),
                    TextColumn::make('instagram_link')
                        ->icon(Phosphor::InstagramLogo)
                        ->url(fn (Counselor $record): ?string => $record->instagram_link ? 'https://instagram.com/'.ltrim($record->instagram_link, '@') : null)
                        ->openUrlInNewTab()
                        ->visible(fn (?Counselor $record): bool => $record && ! empty($record->instagram_link)),
                    TextColumn::make('tiktok_link')
                        ->icon(Phosphor::TiktokLogo)
                        ->url(fn (Counselor $record): ?string => $record->tiktok_link ? 'https://tiktok.com/@'.ltrim($record->tiktok_link, '@') : null)
                        ->openUrlInNewTab()
                        ->visible(fn (?Counselor $record): bool => $record && ! empty($record->tiktok_link)),
                    TextColumn::make('facebook_link')
                        ->icon(Phosphor::FacebookLogo)
                        ->url(fn (Counselor $record): ?string => $record->facebook_link ? 'https://facebook.com/'.ltrim($record->facebook_link, '@') : null)
                        ->openUrlInNewTab()
                        ->visible(fn (?Counselor $record): bool => $record && ! empty($record->facebook_link)),
                    TextColumn::make('contact_email')
                        ->icon(Phosphor::Envelope)
                        ->url(fn (Counselor $record): string => 'mailto:'.$record->contact_email)
                        ->openUrlInNewTab()
                        ->visible(fn (?Counselor $record): bool => $record && ! empty($record->contact_email)),
                ])->collapsible(),
            ])
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 3,
            ])
            ->filters([
                SelectFilter::make('province_id')
                    ->label('Provinsi')
                    ->relationship('province', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('Semua Provinsi'),
                SelectFilter::make('regency_id')
                    ->label('Kota/Kabupaten')
                    ->relationship('regency', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('Semua Kota/Kabupaten'),
            ], FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->deferFilters(false)
            ->paginated([9, 18, 27]);
    }
}
