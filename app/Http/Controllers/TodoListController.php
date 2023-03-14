<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TodoListController extends Controller
{
    public function index(): View
    {
        $todoLists = Auth::user()->todoLists()->get();

        return view('todoLists.index', [
            'todoLists' => $todoLists
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:127'
        ]);

        $request->user()->todoLists()->create($validated);

        return back();
    }

    public function show(Request $request): View|RedirectResponse
    {
        $possibleSortValues = ['asc', 'desc'];
        $sort = $request->query('sort');
        in_array($sort, $possibleSortValues) ?: $sort = 'asc';

        $possibleShowValues = ['all', 'completed', 'uncompleted', 'archived'];
        $show = $request->query('show');
        in_array($show, $possibleShowValues) ?: $show = 'all';

        $todoListQuery = Auth::user()->todoLists()->where('id', $request->list_id)->first();

        // List not found, or not owned by User
        if ($todoListQuery === null) {
            return redirect(route('lists.index'));
        }

        $todoItemQuery = $todoListQuery
            ->TodoItems()
            ->where('archived', $show === 'archived');

        if ($show == 'completed' || $show == 'uncompleted') {
            $todoItemQuery->where('completed', $show == 'completed');
        }

        $todoItems = $todoItemQuery->orderBy('completed')
            ->orderBy('created_at', $sort)
            ->get();

        return view('todoItems.index', [
            'todoItems' => $todoItems,
            'listName' => $todoListQuery->name
        ]);
    }

    public function edit(Request $request): View
    {
        $todoList = Auth::user()->todoLists()->where('id', $request->list_id)->first();

        return view('todoLists.edit', ['todoList' => $todoList, 'list_id' => $request->list_id]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:127'
        ]);

        $todoList = Auth::user()->todoLists()->where('id', $request->list_id)->first();

        $todoList->update($validated);

        return redirect(route('lists.index'));
    }
}
