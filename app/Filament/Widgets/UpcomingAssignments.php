<?php

namespace App\Filament\Widgets;

use App\Models\WheelAssignment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingAssignments extends TableWidget
{
    protected static ?string $heading = 'Upcoming Assignments';

    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 12;
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
                    ->when(auth()->user()?->hasRole('foster'), function ($query) {
                        $fosterId = auth()->user()?->foster?->id;

                        $query->where('foster_id', $fosterId);
                    })
                    ->where('status', 'upcoming')
                    ->orderBy('start_date')
                    ->limit(5)
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
