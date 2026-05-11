<?php

namespace App\Filament\Resources\Fosters\Pages;

use App\Filament\Resources\Fosters\FosterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFosters extends ListRecords
{
    protected static string $resource = FosterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-m-plus'),
        ];
    }
}
