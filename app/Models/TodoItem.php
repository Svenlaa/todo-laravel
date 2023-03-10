<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItem extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'foreign_key');
    }

    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class, 'foreign_key');
    }
}
