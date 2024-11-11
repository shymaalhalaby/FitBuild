<?php

namespace app\Filament\fitbuild\Pages\Tenancy;

use App\Models\gym;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Tenancy\RegisterTenant;

class Registergym extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Fill Your GYM Information';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),
                TextInput::make('address')
                ->required(),
                FileUpload::make('logo')
                ->nullable()
                ->image()
                ->disk('public')
                ->directory('images')
                ->visibility('public')
                ->avatar(),
                TextInput::make('phone_number')
                ->required(),
                TextInput::make('land_number')
                ->required(),
                TextInput::make('description')
                ->required(),
                TextInput::make('WorkHours:women')
                ->required(),
                TextInput::make('WorkHours:men')
                ->required(),
                TextInput::make('SubscriptionPrice:daily')
                ->required(),
                TextInput::make('SubscriptionPrice:3days')
                ->required(),
            ]);
    }


    protected function handleRegistration(array $data): gym
    {
        // Retrieve the currently logged-in user
        $user = Auth::user();

        // Add the user's email and password to the data array

        $data['email'] = $user->email;
        $data['password'] = $user->password;

        // Create the gym with the updated data array
        $gym = gym::create($data);

        // Attach the user to the gym
        $gym->users()->attach($user);

        return $gym;
    }
}
