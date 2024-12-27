<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function superList() {
        return $this->belongsTo(SuperList::class, 'super_list_id');
    }

    // protected $fillable = ['title','message'];
}
