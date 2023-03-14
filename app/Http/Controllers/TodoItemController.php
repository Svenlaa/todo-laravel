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

    public function edit(Request $request): View
    {
        $todoItem = TodoItem::query()->where(['id' => $request->item_id, 'user_id' => Auth::id()])->first();

        return view('todoItems.edit', ['todoItem' => $todoItem]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $todoItem = TodoItem::query()->where(['id' => $request->item_id, 'user_id' => Auth::id()])->first();

        $todoItem->update($validated);

        return redirect(route('lists.show', ['list_id' => $todoItem->todo_list_id]));
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
