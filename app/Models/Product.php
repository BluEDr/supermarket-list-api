<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function superList() {
        return $this->belongsToMany(superList::class, "junction_superlists_products")->withPivot('quantity')->withTimestamps();
    }
}
