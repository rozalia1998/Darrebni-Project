<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable=['question_content','reference','subject_id','term_id'];

    public function subject(): BelongsTo{

        return $this->BelongsTo(Subject::class);

    }

    public function term(): BelongsTo{

        return $this->BelongsTo(Term::class);

    }

    public function answers(): HasMany{

        return $this->hasMany(Answer::class);

    }

    public function users():BelongsToMany{

        return $this->belongsToMany(User::class, 'imporataces')
            ->withTimestamps();

    }


}
