<?php

namespace App\Filament\Resources\Wheels\Pages;

use App\Filament\Resources\Wheels\WheelResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\WheelScheduleService;

class CreateWheel extends CreateRecord
{
    protected static string $resource = WheelResource::class;

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->hidden();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        app(WheelScheduleService::class)
            ->generate($this->record);
    }
}
