<?php

namespace App\Filament\Resources\Fosters;

use App\Filament\Resources\Fosters\Pages\CreateFoster;
use App\Filament\Resources\Fosters\Pages\EditFoster;
use App\Filament\Resources\Fosters\Pages\ListFoster;
use App\Filament\Resources\Fosters\Pages\ViewFoster;
use App\Filament\Resources\Fosters\Schemas\FosterForm;
use App\Filament\Resources\Fosters\Schemas\FosterInfolist;
use App\Filament\Resources\Fosters\Tables\FostersTable;
use App\Models\Foster;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FosterResource extends Resource
{
    protected static ?string $model = Foster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static ?string $recordTitleAttribute = 'Foster';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return FosterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FosterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FostersTable::configure($table);
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
            'index' => ListFoster::route('/'),
            'create' => CreateFoster::route('/create'),
            'view' => ViewFoster::route('/{record}'),
            'edit' => EditFoster::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view fosters');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view fosters');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('manage fosters');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete fosters');
    }

    public static function getEagerLoadedRelationships(): array
    {
        return ['user'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(
                !auth()->user()?->hasRole('super_admin'),
                fn($query) => $query->whereNull('deleted_at')
            );
    }
}
