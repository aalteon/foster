<?php

namespace App\Filament\Resources\Fosters\Pages;

use App\Filament\Resources\Fosters\FosterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewFoster extends ViewRecord
{
    protected static string $resource = FosterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['name'] = $this->record->user->name ?? null;
        $data['email'] = $this->record->user->email ?? null;

        return $data;
    }

    public function getRecord(): Model
    {
        return parent::getRecord()->load('user');
    }
}
