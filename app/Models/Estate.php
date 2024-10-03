<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Estate extends Model
{
    use HasFactory;

    const UNSIGNED_SMALLINT = 33000;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
