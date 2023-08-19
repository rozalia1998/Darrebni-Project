<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable=['user_id','Text_Field'];

    public function users(){
        $this->belongsTo(User::class);
    }
    use HasFactory;
}
