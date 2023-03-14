<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TodoItemController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);


        $validated['user_id'] = Auth::id();


        Auth::user()
            ->todoLists()
            ->where('id', $request->list_id)
            ->first()
            ->todoItems()
            ->create($validated);

        return back();
    }

    public function archive(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->update(['archived' => true, 'archived_at' => now()]);

        return back();
    }


    public function toggle(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->update(["completed" => !$todoItem->completed]);

        return back();
    }
}
