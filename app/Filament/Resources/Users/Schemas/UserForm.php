<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),

                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),

                        Select::make('roles')
                            ->label('Role')
                            ->multiple()
                            ->relationship(
                                'roles',
                                'name',
                                fn($query) => $query->where('name', '!=', 'foster')
                            )
                            ->preload()
                            ->default(fn() => [
                                Role::where('name', 'admin')->value('id')
                            ]),
                    ]),

                TextInput::make('password')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->dehydrated(fn($state) => filled($state)),

                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->same('password')
                    ->dehydrated(false),
            ]);
    }
}
