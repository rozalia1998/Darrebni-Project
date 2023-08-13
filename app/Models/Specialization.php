<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable=['specialization_name','image','collage_id'];

    public function codes(): HasMany{

        return $this->HasMany(Code::class);

    }

    public function collage() :BelongsTo{

        return $this->BelongsTo(Collage::class);

    }

    public function subjects(): HasMany{

        return $this->HasMany(Subject::class);

    }

}
