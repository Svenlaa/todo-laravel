<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoItemController extends Controller
{
    public function index(Request $request): View
    {

        $possibleSortValues = ['asc', 'desc'];
        $sort = $request->query('sort');
        in_array($sort, $possibleSortValues) ?  : $sort = 'asc';

        $possibleShowValues = ['all', 'completed', 'uncompleted'];
        $show = $request->query('show');
        in_array($show, $possibleShowValues) ? : $show = 'all';

        $todoItemQuery = TodoItem::with('user')
            ->where('archived', false);

        if ($show !== 'all') {
            $todoItemQuery->where('completed', $show == 'completed');
        }

        $todoItems = $todoItemQuery->orderBy('completed')
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
