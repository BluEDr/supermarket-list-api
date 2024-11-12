<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function superList() {
        return $this->belongsToMany(SuperList::class, "junction_superlists_products")->withPivot('quantity')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    protected $fillable = [
        'name',
        'unit',
        'barcode',
        'description',
        'user_id'
    ];
}
