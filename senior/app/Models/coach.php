<?php

namespace App\Models;

use App\Models\member;
use App\Models\Request;
use App\Models\Excercise;
use App\Models\sendRequest;
use App\Traits\BelongsToGym;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class coach extends Model
{
    use HasFactory;


    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'coach_member')
            ->using(coach_member::class)
            ->withPivot(['id', 'status'])
            ->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'gender',
        'Age',
        'phone_number',
        'WorkHours',
        'training_price',
        'work_type',
        'user_id',
        'status',
        

    ];
    public function gyms()
    {
        return $this->belongsToMany(Gym::class)->withPivot('status')->withTimestamps();
    }

    public function coachRequests()
    {
        return $this->hasMany(CoachRequest::class);
    }

}
