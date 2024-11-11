<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class week extends Model
{
    use HasFactory;
    protected $fillable = ['member_id', 'diet_id'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }
}
