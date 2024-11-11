<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plane extends Model
{
    use HasFactory;
    protected $table = 'planned_exercises';
    protected $fillable = ['RepeatCount', 'Set','Duration','TrainingTips','RestBreak','TransitionRest','exercise_id','daily_exercise_id'];
    public function Excercise():BelongsTo
{
   return $this->belongsTo(Excercise::class,'exercise_id');
}
public function DailyExercise():BelongsTo
{
   return $this->belongsTo(DailyExercise::class,'daily_exercise_id');
}

}
