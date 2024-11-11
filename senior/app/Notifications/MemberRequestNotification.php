<?php



namespace App\Notifications;

use App\Models\MemberRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MemberRequestNotification extends Notification
{
    use Queueable;

    protected $memberRequest;

    public function __construct(MemberRequest $memberRequest)
    {
        $this->memberRequest = $memberRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new member request',
            'member_request_id' => $this->memberRequest->id,
            'gym_id' => $this->memberRequest->gym_id,
        ];
    }
}
