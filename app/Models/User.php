<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'phone',
    //     'name',
    //     'email',
    //     'password',
    // ];



    protected $guarded = [];


    public static $gender = [
        1=>'male',
        2=>'female',
        3=>'others',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setGenderAttribute($value)
    {
        // $times = explode(",", $value);
        switch ($value) {
            case 'male':
                $this->attributes['gender'] = 1;
              break;
            case 'female':
                $this->attributes['gender'] = 2;
              break;
            case 'other':
                $this->attributes['gender'] = 3;
              break;
          }
    }

    public function getGenderAttribute($value)
    {
        return self::$gender[$value];
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

}
