<?php

namespace App\Filament\Resources\Counselors\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CounselorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Full Name'))
                    ->searchable()
                    ->wrap(),
                TextColumn::make('registration_number')
                    ->label(__('Registration Number'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('degree')
                    ->label(__('Degree'))
                    ->wrap(),
                TextColumn::make('province.name')
                    ->label(__('Province'))
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('regency.name')
                    ->label(__('Regency'))
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('whatsapp_number')
                    ->label(__('WhatsApp Number'))
                    ->searchable(),
                TextColumn::make('contact_email')
                    ->label(__('Contact Email'))
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'gray',
                        'On Leave' => 'warning',
                        'Suspended' => 'danger',
                        'Retired' => 'info',
                        'Terminated' => 'danger',
                        'Probation' => 'warning',
                        'Training' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
