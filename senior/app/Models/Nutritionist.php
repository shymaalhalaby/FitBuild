<?php

namespace App\Models;


use App\Models\member;
use App\Traits\BelongsToGym;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Nutritionist extends Model
{
    use HasFactory;

    /**
     * Get all of the post's comments.
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function member()
    {
        return $this->hasMany(member::class);
    }
    public function gym(): BelongsToMany
    {
        return $this->belongsToMany(gym::class);
    }
    public function members():BelongsToMany
    {
        return $this->belongsToMany(Member::class,'member_nutritionist')
                    ->using(member_nutritionist::class)
                    ->withPivot('status','id')
                    ->withTimestamps();
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


}



