<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CoachRequestNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoachRequest extends Model
{
    use HasFactory ;

    protected $fillable = ['coach_id', 'gym_id', 'status'];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
   
}


