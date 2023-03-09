<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TodoItemController extends Controller
{
    public function index(Request $request): View
    {

        $possibleSortValues = ['asc', 'desc'];
        $sort = $request->query('sort');
        in_array($sort, $possibleSortValues) ?  : $sort = 'asc';

        $todoItems = Auth::user()
            ->todoItems()
            ->where('archived', false)
            ->orderBy('completed')
            ->orderBy('created_at', $sort)
            ->get();

        return view('todoItems.index', [
            'todoItems' => $todoItems
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->todoItems()->create($validated);

        return redirect(route('todo-items.index'));
    }

    public function archive(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->update(['archived' => true, 'archived_at' => now()]);

        return redirect(route('todo-items.index'));
    }

    public function toggle(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->update(["completed" => !$todoItem->completed]);

        return redirect(route('todo-items.index'));
    }
}
