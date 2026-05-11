<?php

namespace App\Filament\Resources\Wheels\Schemas;

use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Toggle;

class WheelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Wheel Information')
                    ->schema([
                        Group::make()
                            ->columns(4)
                            ->columnSpanFull()
                            ->schema([

                                TextInput::make('name')
                                    ->label('Wheel Name')
                                    ->required(),

                                DatePicker::make('rotation_start_date')
                                    ->label('Rotation Start Date')
                                    ->required()
                                    ->disabledOn('edit')
                                    ->dehydrated(),

                                TextInput::make('duration_days')
                                    ->label('Duration Per Rotation')
                                    ->numeric()
                                    ->suffix('days')
                                    ->required()
                                    ->disabledOn('edit')
                                    ->dehydrated(),

                                TextInput::make('generate_days_ahead')
                                    ->label('Generate Schedule Ahead')
                                    ->numeric()
                                    ->suffix('days')
                                    ->required(),

                            ]),
                    ])
                    ->columnSpanFull(),

                Fieldset::make('Pet In this Wheel')
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('pet_id')
                                    ->relationship(
                                        name: 'pets',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn($query, $record) =>
                                        $query->available($record?->id)->orderBy('name')
                                    )
                                    ->getOptionLabelFromRecordUsing(
                                        fn($record) => $record->full_label
                                    )
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                            ]),
                    ])
                    ->columnSpanFull(),

                Fieldset::make('Foster In this Wheel')
                    ->schema([
                        Group::make()
                            ->visibleOn('create')
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('primary_fosters')
                                    ->label('Primary Foster')
                                    ->options(
                                        \App\Models\foster::approved()
                                            ->with('user')
                                            ->get()
                                            ->sortBy(fn($v) => $v->user->name)
                                            ->pluck('user.name', 'id')
                                    )
                                    ->searchable()
                                    ->live()
                                    ->dehydrated(false)
                                    ->required(),

                                Select::make('backup_fosters')
                                    ->label('Backup Foster')
                                    ->options(
                                        \App\Models\foster::approved()
                                            ->with('user')
                                            ->get()
                                            ->sortBy(fn($v) => $v->user->name)
                                            ->pluck('user.name', 'id')
                                    )
                                    ->searchable()
                                    ->live()
                                    ->required(),
                            ]),

                    ])->columnSpanFull(),

                Fieldset::make('Foster In this Wheel')
                    ->schema([
                        Group::make()
                            ->visibleOn('edit')
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([

                                Select::make('new_primary_fosters')
                                    ->label('Add Primary Foster')
                                    ->multiple()

                                    ->options(
                                        \App\Models\Foster::approved()
                                            ->with('user')
                                            ->get()
                                            ->sortBy(fn($v) => $v->user->name)
                                            ->pluck('user.name', 'id')
                                    )

                                    ->searchable()
                                    ->dehydrated(),

                                Select::make('new_backup_fosters')
                                    ->label('Add Backup Foster')
                                    ->multiple()

                                    ->options(
                                        \App\Models\Foster::approved()
                                            ->with('user')
                                            ->get()
                                            ->sortBy(fn($v) => $v->user->name)
                                            ->pluck('user.name', 'id')
                                    )

                                    ->searchable()
                                    ->dehydrated(),

                            ]),

                    ])
                    ->columnSpanFull(),

                Fieldset::make('Current Primary Foster')
                    ->hiddenOn('create')
                    ->schema([

                        Repeater::make('primary_fosters')
                            ->relationship()
                            ->hiddenLabel()
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull()
                            ->table([
                                TableColumn::make('Name')->alignStart(),
                                TableColumn::make('Address')->alignStart(),
                                TableColumn::make('Phone')->alignStart(),
                                TableColumn::make('Actions')->alignCenter(),
                            ])
                            ->schema([

                                Placeholder::make('name')
                                    ->hiddenLabel()
                                    ->content(fn($record) => $record?->foster?->user?->name),

                                Placeholder::make('address')
                                    ->hiddenLabel()
                                    ->content(fn($record) => $record?->foster?->address),

                                Placeholder::make('phone')
                                    ->hiddenLabel()
                                    ->content(fn($record) => $record?->foster?->phone),

                                Placeholder::make('actions')
                                    ->hiddenLabel()
                                    ->content(''),

                            ])
                            ->extraItemActions([

                                /*
                |--------------------------------------------------------------------------
                | Replace Foster
                |--------------------------------------------------------------------------
                */

                                Action::make('replace')
                                    ->label('Replace')
                                    ->icon('heroicon-m-arrow-path')
                                    ->color('warning')

                                    ->form([

                                        Select::make('replacement_foster_id')
                                            ->label('Replace With')
                                            ->options(
                                                \App\Models\Foster::approved()
                                                    ->with('user')
                                                    ->get()
                                                    ->sortBy(fn($v) => $v->user->name)
                                                    ->pluck('user.name', 'id')
                                            )
                                            ->searchable()
                                            ->required(),

                                    ])

                                    ->modalHeading('Replace Foster')
                                    ->modalDescription('This will regenerate future cycles only.')
                                    ->modalSubmitActionLabel('Replace Foster')

                                    ->action(function (array $data, $record) {

                                        /*
                        |--------------------------------------------------------------------------
                        | Current Foster
                        |--------------------------------------------------------------------------
                        */

                                        $oldFosterId = $record->foster_id;

                                        /*
                        |--------------------------------------------------------------------------
                        | Replace Foster
                        |--------------------------------------------------------------------------
                        */

                                        $record->update([
                                            'foster_id' => $data['replacement_foster_id'],
                                        ]);

                                        /*
                        |--------------------------------------------------------------------------
                        | TODO:
                        |--------------------------------------------------------------------------
                        |
                        | regenerate future cycles here
                        | keep historical assignments intact
                        |
                        */
                                    }),

                                /*
                |--------------------------------------------------------------------------
                | Remove Foster
                |--------------------------------------------------------------------------
                */

                                Action::make('remove')
                                    ->label('Remove')
                                    ->icon('heroicon-m-trash')
                                    ->color('danger')

                                    ->requiresConfirmation()

                                    ->modalHeading('Remove Foster')
                                    ->modalDescription('This will remove foster from future cycles and regenerate schedules.')
                                    ->modalSubmitActionLabel('Remove Foster')

                                    ->action(function ($record) {

                                        /*
                        |--------------------------------------------------------------------------
                        | Soft Remove Recommended
                        |--------------------------------------------------------------------------
                        */

                                        $record->update([
                                            'inactive_at' => now(),
                                        ]);

                                        /*
                        |--------------------------------------------------------------------------
                        | TODO:
                        |--------------------------------------------------------------------------
                        |
                        | regenerate future schedules
                        | keep historical assignments
                        |
                        */
                                    }),

                            ]),

                    ])
                    ->columnSpanFull(),

                Fieldset::make('Automation')
                    ->schema([

                        Group::make()
                            ->columns(1)
                            ->schema([

                                Toggle::make('notification')
                                    ->label('Send reminder notifications')
                                    ->default(true),

                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
