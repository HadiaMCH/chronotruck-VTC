<?php

namespace App\Models;

use App\Models\wilaya;
use App\Models\annonce;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 
    protected $fillable = [
        'name',
        'familyname',
        'email',
        'password',
        'address',
        'phone',
        'transporteur',
        'wilaya',
        'certifie',
        'demande',
        'statut',
        'justificatif'
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

    public function annonces()
    {
        return $this->hasMany(annonce::class);
    }

    public function wilayas()
    {
        return $this->belongsToMany(wilaya::class);
    }

}
