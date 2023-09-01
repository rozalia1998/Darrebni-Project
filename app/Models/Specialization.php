<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Traits\GeneratesUuid;

class Specialization extends Model
{
    use HasFactory,GeneratesUuid;

    protected $fillable=['uuid','specialization_name','image','collage_id','has_levels'];

    public function codes(): HasMany{

        return $this->HasMany(Code::class);

    }

    public function collage() :BelongsTo{

        return $this->BelongsTo(Collage::class);

    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function questions(){

        return $this->hasMany(Question::class);
    }

    public function terms(){

        return $this->hasMany(Term::class);
    }

}
