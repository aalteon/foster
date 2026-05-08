<?php

namespace App\Filament\Widgets;

use App\Models\WheelAssignment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FosterWheelStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 12;

    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make(
                'My Assignments',
                WheelAssignment::where('foster_id', $user->id)->count()
            )
                ->description('Total assignments assigned to you')
                ->icon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make(
                'Completed',
                WheelAssignment::where('foster_id', $user->id)
                    ->where('status', 'completed')
                    ->count()
            )
                ->description('Your completed assignments')
                ->icon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
