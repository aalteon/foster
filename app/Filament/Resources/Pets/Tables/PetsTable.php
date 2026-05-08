<?php

namespace App\Filament\Resources\Pets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Models\Pet;

class PetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Image')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('species')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('breed')
                    ->toggleable(),

                TextColumn::make('color')
                    ->toggleable(),

                TextColumn::make('gender')
                    ->badge()
                    ->colors([
                        'primary' => 'male',
                        'pink' => 'female',
                    ])
                    ->toggleable(),

                TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('dob')
                    ->date()
                    ->label('Date of Birth')
                    ->toggleable(),

                /*TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(),*/
            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(fn() => auth()->user()?->can('view trashed pets')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->tooltip('View')
                    ->hiddenLabel()
                    ->modal()
                    ->visible(fn() => auth()->user()?->can('view pets')),
                EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Edit')
                    ->hiddenLabel()
                    ->visible(fn() => auth()->user()?->can('manage pets')),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete pets')),

                ForceDeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete pets')),

                RestoreBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('view trashed pets')),
            ]);
    }
}
