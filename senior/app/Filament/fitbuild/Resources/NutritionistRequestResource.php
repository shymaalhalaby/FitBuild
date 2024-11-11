<?php

namespace App\Filament\fitbuild\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\NutritionistRequest;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\fitbuild\Resources\NutritionistRequestResource\Pages;
use App\Filament\fitbuild\Resources\NutritionistRequestResource\RelationManagers;

class NutritionistRequestResource extends Resource
{
    protected static ?string $model = NutritionistRequest::class;

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
                TextColumn::make('Nutritionist.name')->label('Name')->searchable(),
                TextColumn::make('Nutritionist.email')->label('Email'),
                TextColumn::make('Nutritionist.created_at')->label('Date Of Request'),
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
                ->default(),
            ])
            ->actions([
                Action::make('Accept')
                    ->action(function (NutritionistRequest $record) {
                        $record->status = 'Accept';
                        $record->save();
                    }),
                Action::make('Reject')
                    ->action(function (NutritionistRequest $record) {
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
            'index' => Pages\ListNutritionistRequests::route('/'),
            'create' => Pages\CreateNutritionistRequest::route('/create'),
            'edit' => Pages\EditNutritionistRequest::route('/{record}/edit'),
        ];
    }
}
