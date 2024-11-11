<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\NutritionistRequestNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NutritionistRequest extends Model
{
    use HasFactory;

    protected $fillable = ['nutritionist_id', 'gym_id', 'status'];

    public function nutritionist()
    {
        return $this->belongsTo(Nutritionist::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

}
