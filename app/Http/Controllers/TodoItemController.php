<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $todoItems  = TodoItem::with('user')
            ->where('user_id', Auth::id())
            ->where('archived', false)
            ->latest()
            ->get();

        return view('todoItems.index', [
            'todoItems' => $todoItems,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */


}
