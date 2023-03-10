<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $archivedItems = TodoItem::with('user')
            ->where('user_id', Auth::id())
            ->where('archived', true)
            ->latest()
            ->get();

        return view('todoItems.archive', [
            'todoItems' => $archivedItems
        ]);
    }

    public function restore(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->update(['archived' => false]);
        return back();
    }

    public function delete(TodoItem $todoItem): RedirectResponse
    {
        $todoItem->delete();
        return back();
    }
}
