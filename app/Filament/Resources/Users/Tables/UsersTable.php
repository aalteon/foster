<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role_names')
                    ->label('Role')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(fn() => auth()->user()?->can('view trashed users')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->tooltip('View')
                    ->hiddenLabel()
                    ->modal()
                    ->visible(fn() => auth()->user()?->can('view users')),
                EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Edit')
                    ->hiddenLabel()
                    ->visible(fn() => auth()->user()?->can('manage users')),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete users')),

                ForceDeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete users')),

                RestoreBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('view trashed users')),
            ]);
    }
}
