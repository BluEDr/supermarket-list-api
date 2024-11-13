<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'partner_id'
    ];

    //Many to many relationship with products table
    public function products() {
        return $this->belongsToMany(Product::class, "junction_superlists_products")->withPivot('quantity')->withTimestamps();
    }

    //one to many relationship with users
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partner() {
        return $this->belongsTo(User::class, 'partner_id');
    }

    //one to many relationship with messages
    public function message() {
        return $this->hasMany(Message::class, 'super_list_id');
    }
}
