<?php

namespace App\Filament\fitbuild\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MemberRequest;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\HtmlColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Models\GymMemberRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use app\Filament\fitbuild\Resources\MemberRequestResource\Pages;
use App\Filament\fitbuild\Resources\GymMemberRelationManagerResource\RelationManagers;

class MemberRequestResource extends Resource
{
    protected static ?string $model = MemberRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('member.name')->label('Name')->searchable(),
                TextColumn::make('member.email')->label('Email'),
                TextColumn::make('member.created_at')->label('Date Of Request'),
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
                    ->action(function (MemberRequest $record) {
                        $record->status = 'Accept';
                        $record->save();
                    }),
                Action::make('Reject')
                    ->action(function (MemberRequest $record) {
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
           'index' => Pages\ListMemberRequests::route('/'),
            'create' => Pages\CreateMemberRequest::route('/create'),
            'edit' => Pages\EditMemberRequest::route('/{record}/edit'),
        ];
    }
}
