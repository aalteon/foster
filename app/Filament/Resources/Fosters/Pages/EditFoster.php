<?php

namespace App\Filament\Resources\Fosters\Pages;

use App\Filament\Resources\Fosters\FosterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\Action;

class EditFoster extends EditRecord
{
    protected static string $resource = FosterResource::class;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['name'] = $this->record->user->name ?? null;
        $data['email'] = $this->record->user->email ?? null;

        return $data;
    }

    protected function afterSave(): void
    {
        $userData = $this->data['user'] ?? [];

        $updateData = [
            'name' => $userData['name'] ?? $this->record->user->name,
            'email' => $userData['email'] ?? $this->record->user->email,
        ];

        if (!empty($userData['password'])) {
            $updateData['password'] = Hash::make($userData['password']);
        }

        $this->record->user->update($updateData);
    }

    protected function beforeDelete(): void
    {
        $this->record->user()->delete();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
