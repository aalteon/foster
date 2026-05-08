<?php

namespace App\Filament\Resources\Fosters\Pages;

use App\Filament\Resources\Fosters\FosterResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateFoster extends CreateRecord
{
    protected static string $resource = FosterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole('foster');

        $data['user_id'] = $user->id;

        if (empty($data['foster_image'])) {
            $data['foster_image'] = 'fosters/default.png';
        }

        unset($data['name'], $data['email'], $data['password']);

        return $data;
    }

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->hidden();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
