<?php

namespace App\Filament\fitbuild\Resources\CoachRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\fitbuild\Resources\CoachRequestResource;

class EditCoachRequest extends EditRecord
{
    protected static string $resource = CoachRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
