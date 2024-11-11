<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\NutritionistRequest;
use Illuminate\Notifications\Notification;

class NutritionistRequestNotification extends Notification
{
    use Queueable;

    protected $nutritionistRequest;

    public function __construct(NutritionistRequest $nutritionistRequest)
    {
        $this->nutritionistRequest = $nutritionistRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new nutritionist request',
            'nutritionist_request_id' => $this->nutritionistRequest->id,
            'gym_id' => $this->nutritionistRequest->gym_id,
        ];
    }
}
