<?php

namespace App\Models;

use App\Models\User;
use App\Models\coach;
use App\Traits\BelongsToGym;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class member extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
    public function Nutritionist()
    {
        return $this->belongsTo(Nutritionist::class);
    }
    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(Coach::class, 'coach_member')
            ->using(coach_member::class)
            ->withPivot('status','id')
            ->withTimestamps();
    }
    public function Nutritionists(): BelongsToMany
    {
        return $this->belongsToMany(Nutritionist::class, 'member_nutritionist')
            ->using(member_nutritionist::class)
            ->withPivot('status','id')
            ->withTimestamps();
    }
    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'weeks');
    }

    public function DailyExercise(): HasMany
    {
        return $this->hasMany(DailyExercise::class, 'member_id');
    }

    public function gym(): BelongsToMany
    {
        return $this->belongsToMany(gym::class)->withPivot('status')->withTimestamps();
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'phone_number',
        'Subscription_type',
        'Age',
        'illness',
        'GOAL',
        'Physical_case',
        'Hieght',
        'Wieght',
        'target_Wieght',
        'AT',
        'user_id',
        'id',
    ];

    public function image()
    {
        return $this->hasOne(Image::class);
    }

}
