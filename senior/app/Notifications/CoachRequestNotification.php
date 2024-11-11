<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CoachRequestNotification extends Notification
{
    use Queueable;

    protected $coachRequest;

    public function __construct($coachRequest)
    {
        $this->coachRequest = $coachRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'message' => 'You have a new coach request',
            'coach_request_id' => $this->coachRequest->id,
            'gym_id' => $this->coachRequest->gym_id,
            
        ];
    }
}
