<?php

namespace App\Filament\fitbuild\Resources\NutritionistRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\fitbuild\Resources\NutritionistRequestResource;

class ListNutritionistRequests extends ListRecords
{
    protected static string $resource = NutritionistRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
