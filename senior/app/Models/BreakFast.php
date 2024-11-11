<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BreakFast extends Model
{
    use HasFactory;
    protected $table = 'break_fasts';
    protected $fillable = ['name'];
   
}
