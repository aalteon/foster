<?php

namespace App\Filament\Resources\Fosters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class FostersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foster_image')
                    ->disk('public')
                    ->label('Image')
                    ->circular(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'pending',
                        'pink' => 'approved',
                    ])
                    ->toggleable(),
                TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(fn() => auth()->user()?->can('view trashed Fosters')),
            ])
            ->recordUrl(null)
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->tooltip('View')
                    ->hiddenLabel()
                    ->modal()
                    ->visible(fn() => auth()->user()?->can('view fosters')),
                EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Edit')
                    ->hiddenLabel()
                    ->visible(fn() => auth()->user()?->can('manage fosters')),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete fosters')),

                ForceDeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete fosters')),

                RestoreBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('view trashed fosters')),
            ]);
    }
}
