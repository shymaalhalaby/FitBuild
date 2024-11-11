<?php
namespace app\Filament\fitbuild\Pages\Tenancy;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditgymProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Gym profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('address'),
                FileUpload::make('logo')
                ->nullable()
                ->image()
                ->disk('public')
                ->directory('images')
                ->visibility('public')
                ->avatar(),
                TextInput::make('phone_number'),
                TextInput::make('land_number'),
                TextInput::make('description'),
                TextInput::make('WorkHours:women'),
                TextInput::make('WorkHours:men'),
                TextInput::make('SubscriptionPrice:daily'),
                TextInput::make('SubscriptionPrice:3days'),
            ]);
    }
}
