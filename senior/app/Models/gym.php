<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class gym extends Model
{
    use HasFactory ,Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'logo',
        'phone_number',
        'land_number',
        'description',
        'workhours_women',
        'workhours_men',
        'subscriptionprice_daily',
        'subscriptionprice_3days',
        'user_id',
        'id',

      ];
      protected $casts = [
        'logo' => 'array',
    ];

      public function coaches()
    {
        return $this->belongsToMany(Coach::class)->withPivot('status')->withTimestamps();
    }
    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function members()
    {
        return $this->belongsToMany(member::class,)->withPivot('status')->withTimestamps();
    }
    public function notifications()
    {
        return $this->morphMany('Illuminate\Notifications\DatabaseNotification', 'notifiable')->orderBy('created_at', 'desc');
    }
    public function getLogoUrlAttribute()
    {
        $url = $this->logo ? Storage::url($this->logo) : null;
        Log::info("Generated logo URL: {$url}");
        return $url;
    }

}

