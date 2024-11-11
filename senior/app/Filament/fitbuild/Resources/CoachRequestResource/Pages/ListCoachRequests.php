<?php

namespace App\Filament\fitbuild\Resources\CoachRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\fitbuild\Resources\CoachRequestResource;

class ListCoachRequests extends ListRecords
{
    protected static string $resource = CoachRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
