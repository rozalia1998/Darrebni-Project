<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable=['name','Specialization_id'];

    public function specialization(): BelongsTo{

        return $this->BelongsTo(Specialization::class);

    }

    public function terms(): HasMany {

        return $this->HasMany(Term::class);

    }

    public function questions(): HasMany {

        return $this->HasMany(Question::class);

    }
}
