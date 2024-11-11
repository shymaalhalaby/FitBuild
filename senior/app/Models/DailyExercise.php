<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyExercise extends Model
{
    use HasFactory;
    protected $table = 'daily_exercises';
    protected $fillable = ['title','member_id','status'];

    public function Plane():HasMany
    {
       return $this->hasMany(Plane::class,'daily_exercise_id');
    }

    public function member():BelongsTo
{
   return $this->belongsTo(member::class,'member_id');
}
}
