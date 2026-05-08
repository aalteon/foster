<?php

namespace App\Filament\Pages;

use BackedEnum;
use App\Filament\Widgets\UpcomingAssignments;
use App\Filament\Widgets\FosterWheelStats;
use App\Filament\Widgets\WheelStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {

        $user = auth()->user();

        return match (true) {
            $user?->hasRole('foster') => [
                FosterWheelStats::class,
                UpcomingAssignments::class,
            ],
            default => [
                WheelStats::class,
                UpcomingAssignments::class,
            ],
        };
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}
