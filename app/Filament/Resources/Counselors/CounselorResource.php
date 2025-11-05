<?php

namespace App\Filament\Resources\Counselors;

use App\Filament\Resources\Counselors\Pages\CreateCounselor;
use App\Filament\Resources\Counselors\Pages\EditCounselor;
use App\Filament\Resources\Counselors\Pages\ListCounselors;
use App\Filament\Resources\Counselors\Pages\ViewCounselor;
use App\Filament\Resources\Counselors\Schemas\CounselorForm;
use App\Filament\Resources\Counselors\Schemas\CounselorInfolist;
use App\Filament\Resources\Counselors\Tables\CounselorsTable;
use App\Models\Counselor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CounselorResource extends Resource
{
    protected static ?string $model = Counselor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected static ?string $recordTitleAttribute = 'registration_number';

    protected static ?string $modelLabel = 'Terapis';

    public static function getNavigationGroup(): ?string
    {
        return __('Account Management');
    }

    public static function form(Schema $schema): Schema
    {
        return CounselorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CounselorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CounselorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCounselors::route('/'),
            'create' => CreateCounselor::route('/create'),
            'view' => ViewCounselor::route('/{record}'),
            'edit' => EditCounselor::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
