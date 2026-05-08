<?php

namespace App\Filament\Resources\Wheels\Schemas;

use Filament\Schemas\Schema;
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
                                    ->required(),

                                TextInput::make('duration_days')
                                    ->label('Duration Per Rotation')
                                    ->numeric()
                                    ->suffix('days')
                                    ->required(),

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

                Fieldset::make('foster In this Wheel')
                    ->schema([
                        Repeater::make('primary_fosters')
                            ->relationship()
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->table([
                                TableColumn::make('Name')->alignStart(),
                                TableColumn::make('Address')->alignStart(),
                                TableColumn::make('Phone')->alignStart(),
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {

                                $data['type'] = 'primary';
                                $data['joined_at'] = now();

                                return $data;
                            })
                            ->schema([
                                Select::make('foster_id')
                                    ->label('foster')
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

                                Placeholder::make('address')
                                    ->label('Address')
                                    ->content(function (callable $get) {

                                        $fosterId = $get('foster_id');

                                        if (!$fosterId) {
                                            return '-';
                                        }

                                        return \App\Models\foster::find($fosterId)?->address;
                                    }),

                                Placeholder::make('phone')
                                    ->label('Phone')
                                    ->content(function (callable $get) {

                                        $fosterId = $get('foster_id');

                                        if (!$fosterId) {
                                            return '-';
                                        }

                                        return \App\Models\foster::find($fosterId)?->phone;
                                    }),
                            ]),
                    ])->columnSpanFull(),

                Fieldset::make('Backup foster In this Wheel')
                    ->schema([
                        Repeater::make('backup_fosters')
                            ->relationship()
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->table([
                                TableColumn::make('Name')->alignStart(),
                                TableColumn::make('Address')->alignStart(),
                                TableColumn::make('Phone')->alignStart(),
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {

                                $data['type'] = 'backup';
                                $data['joined_at'] = now();

                                return $data;
                            })
                            ->schema([
                                Select::make('foster_id')
                                    ->label('foster')
                                    ->options(
                                        \App\Models\foster::approved()
                                            ->with('user')
                                            ->get()
                                            ->sortBy(fn($v) => $v->user->name)
                                            ->pluck('user.name', 'id')
                                    )
                                    ->searchable()
                                    ->live(),

                                Placeholder::make('address')
                                    ->label('Address')
                                    ->content(function (callable $get) {

                                        $fosterId = $get('foster_id');

                                        if (!$fosterId) {
                                            return '-';
                                        }

                                        return \App\Models\foster::find($fosterId)?->address;
                                    }),

                                Placeholder::make('phone')
                                    ->label('Phone')
                                    ->content(function (callable $get) {

                                        $fosterId = $get('foster_id');

                                        if (!$fosterId) {
                                            return '-';
                                        }

                                        return \App\Models\foster::find($fosterId)?->phone;
                                    }),
                            ]),
                    ])->columnSpanFull(),

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
