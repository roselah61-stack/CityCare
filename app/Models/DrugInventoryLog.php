<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugInventoryLog extends Model
{
    protected $fillable = [
        'drug_id',
        'quantity',
        'type',
        'description',
        'user_id'
    ];

    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
