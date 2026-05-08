<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use App\Models\WheelAssignment;
use Filament\Tables;

class CurrentAssignments extends TableWidget
{
    protected static ?string $heading = 'Current Assignments';

    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 6;
    protected bool $columnSpanFull = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WheelAssignment::query()
                    ->with([
                        'foster.user',
                        'wheel',
                    ])
                    ->where('status', 'upcoming')
                    ->orderBy('start_date')
                    ->limit(10)
            )
            ->columns([

                Tables\Columns\TextColumn::make('foster.user.name')
                    ->label('foster')
                    ->searchable(),

                Tables\Columns\TextColumn::make('wheel.name')
                    ->label('Wheel'),

                Tables\Columns\TextColumn::make('pets')
                    ->label('Pets')
                    ->getStateUsing(
                        fn($record) =>
                        $record->wheel->pets
                            ->pluck('name')
                            ->join(', ')
                    ),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start')
                    ->date('d M Y'),

            ]);
    }
}
