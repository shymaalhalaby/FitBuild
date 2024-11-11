<?php

namespace App\Filament\fitbuild\Resources\MemberRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\fitbuild\Resources\MemberRequestResource;

class EditMemberRequest extends EditRecord
{
    protected static string $resource = MemberRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
