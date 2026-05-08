<?php

namespace App\Filament\Resources\Wheels\Pages;

use App\Filament\Resources\Wheels\WheelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWheels extends ListRecords
{
    protected static string $resource = WheelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-m-plus'),
        ];
    }
}
