<?php

namespace App\Filament\Resources\Wheels\Pages;

use App\Filament\Resources\Wheels\WheelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditWheel extends EditRecord
{
    protected static string $resource = WheelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            Action::make('back')
                ->label('Back to list')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->icon('heroicon-m-arrow-left'),

            DeleteAction::make()
                ->label('Delete')
                ->color('danger')
                ->icon('heroicon-m-trash'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        foreach ($data['new_primary_fosters'] ?? [] as $fosterId) {

            \App\Models\WheelMember::create([
                'wheel_id' => $this->record->id,
                'foster_id' => $fosterId,
                'type' => 'primary',
                'joined_at' => now(),
            ]);
        }

        foreach ($data['new_backup_fosters'] ?? [] as $fosterId) {

            \App\Models\WheelMember::create([
                'wheel_id' => $this->record->id,
                'foster_id' => $fosterId,
                'type' => 'backup',
                'joined_at' => now(),
            ]);
        }
    }
}
