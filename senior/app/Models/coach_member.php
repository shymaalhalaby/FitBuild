<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class coach_member extends Pivot
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'coach_member';
    protected $fillable = [
        'id',
        'member_id',
        'coach_id',
        'status'
    ];

}
