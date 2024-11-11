<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Excercise extends Model
{
    use HasFactory;
    protected $table = 'exercises';
    protected $fillable = ['name', 'description','video','TargetMuscles'];
    public function Plane():hasMany
    {
       return $this->hasMany(Plane::class,'exercise_id');
    }


    public function getRouteKeyName()
    {
        return 'name'; // Use the 'name' column for route model binding.
    }
}


