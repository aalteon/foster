<?php

namespace App\Filament\Resources\Pets\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->label('Profile Photo')
                    ->disk('public')
                    ->columnSpanFull(),

                TextEntry::make('name'),

                TextEntry::make('species'),

                TextEntry::make('breed'),

                TextEntry::make('color'),

                TextEntry::make('gender'),

                TextEntry::make('dob'),

                TextEntry::make('weight'),

                TextEntry::make('description'),
            ]);
    }
}
