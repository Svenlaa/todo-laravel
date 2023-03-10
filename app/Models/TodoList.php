<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TodoList extends Model
{
    use HasFactory;

    public function todoItems(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'foreign_key');
    }
}
