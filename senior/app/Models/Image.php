<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'image_path'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
