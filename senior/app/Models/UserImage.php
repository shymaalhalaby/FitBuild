<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserImage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'image_path', 'cv_path'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
