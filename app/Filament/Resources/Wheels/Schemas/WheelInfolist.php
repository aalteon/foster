<?php

namespace App\Filament\Resources\Wheels\Schemas;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Carbon\Carbon;

class WheelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Wheel Details')
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('Overview')
                            ->schema([
                                Section::make('Wheel Information')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Wheel Name'),

                                        TextEntry::make('is_active')
                                            ->label('Status')
                                            ->badge()
                                            ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                                            ->color(fn($state) => $state ? 'success' : 'danger'),

                                        TextEntry::make('created_at')
                                            ->dateTime(),

                                        TextEntry::make('updated_at')
                                            ->dateTime(),

                                        TextEntry::make('currentAssignment')
                                            ->label('Current')
                                            ->html()
                                            ->state(function ($record) {

                                                $assignment = $record->currentAssignment;

                                                if (! $assignment) {
                                                    return '-';
                                                }

                                                $name = ucwords(strtolower(
                                                    $assignment->foster->user->name
                                                ));

                                                $date = $assignment->end_date
                                                    ->format('M d, Y');

                                                return "
            <strong>{$name}</strong><br>
            <span class='text-sm text-gray-500'>
                Until {$date}
            </span>
        ";
                                            }),

                                        TextEntry::make('nextAssignment')
                                            ->label('Next')
                                            ->html()
                                            ->state(function ($record) {

                                                $assignment = $record->nextAssignment;

                                                if (!$assignment) {
                                                    return '-';
                                                }

                                                $name = ucwords(
                                                    strtolower(
                                                        $assignment->foster->user->name
                                                    )
                                                );

                                                $date = $assignment->start_date
                                                    ->format('M d, Y');

                                                return "
            <strong>{$name}</strong><br>
            <span class='text-sm text-gray-500'>
                Starts {$date}
            </span>
        ";
                                            }),
                                    ]),

                                Section::make('Summary')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('primary_fosters')
                                            ->label('Primary Fosters')
                                            ->state(fn($record) => $record->primary_fosters()->count()),

                                        TextEntry::make('backup_fosters')
                                            ->label('Backup fosters')
                                            ->state(fn($record) => $record->backup_fosters()->count()),

                                        TextEntry::make('pets_count')
                                            ->label('Pets')
                                            ->state(fn($record) => $record->pets()->count()),
                                    ]),
                            ]),

                        Tab::make('Fosters')
                            ->schema([
                                Section::make('Primary Fosters')
                                    ->schema([
                                        TextEntry::make('fosters')
                                            ->label('Primary Fosters')
                                            ->hiddenLabel()
                                            ->state(
                                                fn($record) =>
                                                $record->primary_fosters
                                                    ->map(
                                                        fn($p) =>
                                                        "{$p->foster->user->name} - {$p->foster->phone} - {$p->foster->address}"
                                                    )
                                                    ->toArray()
                                            )
                                            ->bulleted(),
                                    ]),

                                Section::make('Backup Fosters')
                                    ->schema([
                                        TextEntry::make('fosters')
                                            ->label('Backup Fosters')
                                            ->hiddenLabel()
                                            ->state(
                                                fn($record) =>
                                                $record->backup_fosters
                                                    ->map(
                                                        fn($p) =>
                                                        "{$p->foster->user->name} - {$p->foster->phone} - {$p->foster->address}"
                                                    )
                                                    ->toArray()
                                            )
                                            ->bulleted(),
                                    ]),
                            ]),

                        Tab::make('Assignments')
                            ->schema([
                                Section::make('Wheel Assignments')
                                    ->schema([
                                        TextEntry::make('assignments')
                                            ->label('Assignments')
                                            ->state(
                                                fn($record) =>
                                                $record->assignments
                                                    ->map(
                                                        fn($a) =>
                                                        "{$a->foster->user->name} - "
                                                            . Carbon::parse($a->start_date)->format('d M Y')
                                                            . " ("
                                                            . Carbon::parse($a->end_date)->format('d M Y')
                                                            . ")"
                                                    )
                                                    ->toArray()
                                            )
                                            ->bulleted(),
                                    ]),
                            ]),

                        Tab::make('Pets')
                            ->schema([
                                Section::make('Pets in Wheel')
                                    ->schema([
                                        TextEntry::make('pets_list')
                                            ->label('Pets')
                                            ->state(
                                                fn($record) =>
                                                $record->pets
                                                    ->unique('id')
                                                    ->map(fn($p) => "{$p->name} - {$p->species}")
                                                    ->toArray()
                                            )
                                            ->bulleted(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
