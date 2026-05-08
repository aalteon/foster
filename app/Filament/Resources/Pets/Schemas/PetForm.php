<?php

namespace App\Filament\Resources\Pets\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class PetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->image()
                    ->directory('pets')
                    ->disk('public'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('species')
                    ->options([
                        'Cat' => 'Cat',
                        'Dog' => 'Dog',
                    ])
                    ->required()
                    ->searchable(),

                TextInput::make('breed'),

                TextInput::make('color'),

                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required(),

                DatePicker::make('dob'),

                TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg'),

                Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
