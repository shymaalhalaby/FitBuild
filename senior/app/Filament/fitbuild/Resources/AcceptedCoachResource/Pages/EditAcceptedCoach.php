<?php

namespace App\Filament\Fitbuild\Resources\AcceptedCoachResource\Pages;

use App\Filament\Fitbuild\Resources\AcceptedCoachResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcceptedCoach extends EditRecord
{
    protected static string $resource = AcceptedCoachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
