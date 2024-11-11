<?php
namespace App\Models;


use Filament\Panel;
use App\Models\member;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }
    public function gym(): HasOne
    {
        return $this->hasOne(gym::class);
    }

    public function coach(): hasOne
    {
        return $this->hasOne(coach::class);
    }

    public function Nutritionist(): hasOne
    {
        return $this->hasOne(Nutritionist::class);
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',


    ];
    public function image()
    {
        return $this->hasOne(UserImage::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',


    ];
    protected $attributes = [
        'role' => 'Coach' | 'Nutritionist' | 'member' ,

    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
