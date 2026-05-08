<?php

namespace App\Filament\Resources\Fosters\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class FosterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('foster_image')
                    ->label('Profile Photo')
                    ->disk('public')
                    ->columnSpanFull(),

                TextEntry::make('name')
                    ->label('Name')
                    ->state(fn($record) => $record->user?->name),

                TextEntry::make('email')
                    ->label('Email')
                    ->state(fn($record) => $record->user?->email),

                TextEntry::make('phone'),

                TextEntry::make('status'),

                TextEntry::make('address'),

                TextEntry::make('description'),
            ]);
    }
}
