<?php

namespace App\Filament\Fitbuild\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcceptedCoach;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Fitbuild\Resources\AcceptedCoachResource\Pages;
use App\Filament\Fitbuild\Resources\AcceptedCoachResource\RelationManagers;

class AcceptedCoachResource extends Resource
{
    protected static ?string $model = AcceptedCoach::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('Coach.name')->label('Name')->searchable(),
                TextColumn::make('Coach.Age')->label('age')->searchable(),
                TextColumn::make('Coach.email')->label('Email'),
                TextColumn::make('Coach.created_at')->label('Date Of Request'),
                // TextColumn::make('member.coach.name')->label('coach'),

            ])
            ->filters([

            ])
            ->actions([
                Action::make('Accept')
                    ->action(function (AcceptedCoach $record) {
                        $record->status = 'Accept';
                        $record->save();
                    }),
                Action::make('Reject')
                    ->action(function (AcceptedCoach $record) {
                        $record->status = 'Reject';
                        $record->save();
                    }),
            ])
            ->bulkActions([


                BulkAction::make('Save')
                ->requiresConfirmation()
                ->action(function (Collection $records) {
                    foreach ($records as $record) {
                        if ($record->status !== 'pending') {
                            $record->update(['hidden' => true]); // Mark the record as hidden
                        }
                    }
                      // Adding a notification
                      Notification::make()
                      ->title('Records Updated')
                      ->success()
                      ->send();

                  // Using Livewire's redirect method
                 // return redirect()->route('dashboard');
                    }),
                    BulkAction::make('Accept')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                                $record->status = 'Accept';
                                $record->save();

                        }
                    }),
                    BulkAction::make('Reject')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                                $record->status = 'Reject';
                                $record->save();

                        }
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcceptedCoaches::route('/'),
            'create' => Pages\CreateAcceptedCoach::route('/create'),
            'edit' => Pages\EditAcceptedCoach::route('/{record}/edit'),
        ];
    }
}
