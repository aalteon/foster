<?php

namespace App\Filament\Resources\Wheels;

use App\Filament\Resources\Wheels\Pages\CreateWheel;
use App\Filament\Resources\Wheels\Pages\EditWheel;
use App\Filament\Resources\Wheels\Pages\ListWheels;
use App\Filament\Resources\Wheels\Pages\ViewWheel;
use App\Filament\Resources\Wheels\Schemas\WheelForm;
use App\Filament\Resources\Wheels\Schemas\WheelInfolist;
use App\Filament\Resources\Wheels\Tables\WheelsTable;
use App\Models\Wheel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\WheelMember;

class WheelResource extends Resource
{
    protected static ?string $model = Wheel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return WheelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WheelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WheelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWheels::route('/'),
            'create' => CreateWheel::route('/create'),
            'view' => ViewWheel::route('/{record}'),
            'edit' => EditWheel::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view wheels');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('manage wheels');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete wheels');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(
                ! auth()->user()?->hasRole('super_admin'),
                fn($query) => $query
            )
            ->with([
                'primary_fosters',
                'backup_fosters',
                'currentAssignment.foster.user',
                'nextAssignment.foster.user',
            ]);
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        $fosterIds = $data['primary_fosters'] ?? [];

        foreach ($fosterIds as $fosterId) {

            WheelMember::firstOrCreate([
                'wheel_id' => $this->record->id,
                'foster_id' => $fosterId,
                'type' => 'primary',
            ], [
                'joined_at' => now(),
            ]);
        }
    }
}
