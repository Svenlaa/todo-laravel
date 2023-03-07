<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TodoItemController as ControllersTodoItemController;
use App\Models\TodoItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('todoItems.index', [
            'todoItems' => TodoItem::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(TodoItem $todoItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoItem $todoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TodoItem $todoItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoItem $todoItem)
    {
        //
    }
}
