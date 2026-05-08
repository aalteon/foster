<?php

namespace App\Filament\Resources\Wheels\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\IconColumn;

class WheelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Wheel Name')
                    ->searchable(),

                TextColumn::make('duration_days')
                    ->label('Duration')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->suffix(' days'),

                TextColumn::make('rotation_start_date')
                    ->label('Start Date')
                    ->date(),

                TextColumn::make('pets_label')
                    ->label('Pets')
                    ->wrap(),

                TextColumn::make('currentAssignment')
                    ->label('Current')
                    ->html()
                    ->state(function ($record) {

                        $assignment = $record->currentAssignment;

                        if (! $assignment) {
                            return '-';
                        }

                        $name = ucwords(strtolower(
                            $assignment->foster->user->name
                        ));

                        $date = $assignment->end_date
                            ->format('M d, Y');

                        return "
            <strong>{$name}</strong><br>
            <span class='text-sm text-gray-500'>
                Until {$date}
            </span>
        ";
                    }),
                TextColumn::make('nextAssignment')
                    ->label('Next')
                    ->html()
                    ->state(function ($record) {

                        $assignment = $record->nextAssignment;

                        if (!$assignment) {
                            return '-';
                        }

                        $name = ucwords(
                            strtolower(
                                $assignment->foster->user->name
                            )
                        );

                        $date = $assignment->start_date
                            ->format('M d, Y');

                        return "
            <strong>{$name}</strong><br>
            <span class='text-sm text-gray-500'>
                Starts {$date}
            </span>
        ";
                    }),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                IconColumn::make('notification')
                    ->label('Notification')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),

                TextColumn::make('members_summary')
                    ->label('Members')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->html()
                    ->state(function ($record) {

                        $primary = $record->primary_fosters->count();
                        $backup = $record->backup_fosters->count();

                        return "
            <strong>{$primary}</strong> primary<br>
            <strong>{$backup}</strong> backup
        ";
                    }),

            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(fn() => auth()->user()?->can('view trashed wheels')),
            ])
            ->recordUrl(null)
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->tooltip('View')
                    ->hiddenLabel()
                    ->modal()
                    ->visible(fn() => auth()->user()?->can('view wheels')),
                EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Edit')
                    ->hiddenLabel()
                    ->visible(fn() => auth()->user()?->can('manage wheels')),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('delete wheels')),

                ForceDeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('view trashed wheels')),

                RestoreBulkAction::make()
                    ->visible(fn() => auth()->user()?->can('view trashed wheels')),
            ]);
    }
}
