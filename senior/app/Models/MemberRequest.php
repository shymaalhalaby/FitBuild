<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MemberRequestNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberRequest extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'gym_id', 'status'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}

