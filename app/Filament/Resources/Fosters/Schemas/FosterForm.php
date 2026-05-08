<?php

namespace App\Filament\Resources\Fosters\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class FosterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('foster_image')
                    ->image()
                    ->directory('fosters')
                    ->disk('public')
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('name', Str::title($state))
                    )
                    ->disabled(fn(string $context): bool => $context === 'edit')
                    ->helperText('Name cannot be changed after it has been created.'),

                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->disabled(fn(string $context): bool => $context === 'edit')
                    ->helperText('Email cannot be changed after it has been created.'),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),

                Textarea::make('address')
                    ->label('Address')
                    ->required(),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                    ])
                    ->searchable(),

                Textarea::make('description')
                    ->label('Description'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->confirmed()
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context) => $context === 'create'),

                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrated(false),
            ]);
    }
}
