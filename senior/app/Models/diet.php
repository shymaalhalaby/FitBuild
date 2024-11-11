<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class diet extends Model
{
    use HasFactory;
    protected $fillable = [
        'BreakFast1',
        'BreakFast2',
        'BreakFast3',
        'BreakFast1_amount',
        'BreakFast2_amount',
        'BreakFast3_amount',
        'snack1',
        'Lunch1',
        'Lunch2',
        'Lunch1_amount',
        'Lunch2_amount',
        'snack2',
        'Dinner1',
        'Dinner2',
        'Dinner1_amount',
        'Dinner2_amount',
        'totalcalories',
        'notes',

    ];
    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'weeks');
    }
}
