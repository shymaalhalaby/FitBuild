<?php

namespace App\Filament\fitbuild\Resources\MemberRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\fitbuild\Resources\MemberRequestResource;

class ListMemberRequests extends ListRecords
{
    protected static string $resource = MemberRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
