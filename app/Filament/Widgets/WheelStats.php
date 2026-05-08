<?php

namespace App\Filament\Widgets;

use App\Models\Pet;
use App\Models\Foster;
use App\Models\Wheel;
use App\Models\WheelAssignment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WheelStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 12;

    protected function getStats(): array
    {
        return [

            Stat::make(
                'Active Wheels',
                Wheel::where('is_active', true)->count()
            )
                ->description('Currently active wheels')
                ->icon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make(
                'Upcoming Assignments',
                WheelAssignment::where('status', 'upcoming')->count()
            )
                ->description('Future schedules')
                ->icon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make(
                'Approved Fosters',
                Foster::approved()->count()
            )
                ->description('Available Fosters')
                ->icon('heroicon-m-users')
                ->color('info'),

            Stat::make(
                'Assigned Pets',
                Pet::has('wheels')->count()
            )
                ->description('Pets currently assigned')
                ->icon('heroicon-m-heart')
                ->color('success'),

        ];
    }
}
