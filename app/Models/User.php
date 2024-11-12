<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    //For partners table
    public function user_id() {
        return $this->hasMany(Partner::class, 'user_id');
    }

    public function partners_id() {
        return $this->hasMany(Partner::class, 'partner_id');
    }

    //For super_lists table
    public function superListsUser() {
        return $this->hasMany(SuperList::class, 'user_id');
    }

    public function superListsPatner() {
        return $this->hasMany(SuperList::class, 'partner_id');
    }

    //For messages table
    public function message() {
        return $this->hasMany(Message::class, 'user_id');
    }

    //For products table
    public function product() {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
