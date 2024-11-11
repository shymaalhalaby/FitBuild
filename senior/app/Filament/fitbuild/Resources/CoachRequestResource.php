<?php

namespace App\Filament\fitbuild\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CoachRequest;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\fitbuild\Resources\CoachRequestResource\Pages;
use App\Filament\fitbuild\Resources\CoachRequestResource\RelationManagers;

class CoachRequestResource extends Resource
{
    protected static ?string $model = CoachRequest::class;

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
                TextColumn::make('Coach.email')->label('Email'),
                TextColumn::make('Coach.created_at')->label('Date Of Request'),
                // TextColumn::make('member.coach.name')->label('coach'),
                IconColumn::make('status')
                    ->label('Status Of Request')
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'Reject' => 'heroicon-o-x-circle',
                        'Accept' => 'heroicon-o-check-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'secondary',
                        'Reject' => 'danger',
                        'Accept' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('Request')
                ->query(fn (Builder $query) => $query->where('hidden', false))
                ->default()
            ])
            ->actions([
                Action::make('Accept')
                    ->action(function (CoachRequest $record) {
                        $record->status = 'Accept';
                        $record->save();
                    }),
                Action::make('Reject')
                    ->action(function (CoachRequest $record) {
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
            'index' => Pages\ListCoachRequests::route('/'),
            'create' => Pages\CreateCoachRequest::route('/create'),
            'edit' => Pages\EditCoachRequest::route('/{record}/edit'),
        ];
    }
}
