<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory;

    protected $fillable=['term_name','subject_id'];

    public function subject(): BelongsTo{

        return $this->belongsTo(Subject::class);

    }

    public function questions(): HasMany {

        return $this->HasMany(Question::class);

    }
}
