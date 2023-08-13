<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collage extends Model
{
    use HasFactory;

    protected $fillable=['collage_name'];

    public function specializations(): HasMany{

        return $this->HasMany(Specialization::class);

    }


}
