<?php

namespace App\Filament\fitbuild\Resources\NutritionistRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\fitbuild\Resources\NutritionistRequestResource;

class EditNutritionistRequest extends EditRecord
{
    protected static string $resource = NutritionistRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
