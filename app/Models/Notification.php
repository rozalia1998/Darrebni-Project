<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\GeneratesUuid;

class Notification extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable = [
        'uuid',
        'title',
        'body',
    ];
}
