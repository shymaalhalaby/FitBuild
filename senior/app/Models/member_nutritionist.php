<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class member_nutritionist extends Pivot
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'member_nutritionist';
    protected $fillable = [
        'member_id',
        'nutritionist_id',
        'status'
    ];

}
