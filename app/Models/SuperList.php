<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperList extends Model
{
    use HasFactory;
    public function products() {
        return $this->belongsToMany(Product::class, "junction_superlists_products")->withPivot('quantity')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class, user_id);
    }

    public function partner() {
        return $this->belongsTo(User::class, partner_id);
    }
}
