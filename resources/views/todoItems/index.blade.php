<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Todo List > ' . $listName  }}
        </h2>
    </x-slot>

    <div class="w-1/2 mx-auto flex-col flex p-8">
        <form method="POST" action="{{ route('todo.store', ['list_id' => request()->list_id]) }}"
              class="w-full p-4 rounded-md bg-gray-700 flex flex-row justify-between gap-2">
            @csrf
            <input type="text" name="message" class="w-full p-2 rounded-sm" placeholder="What should be done?"/>

            <x-primary-button class="bg-green-700 text-white">{{ __('Add') }}</x-primary-button>
        </form>

        <div class="flex flex-col gap-4 w-4/5 mx-auto py-4">

            <div class="flex flex-row justify-between items-center w-11/12 mx-auto text-white font-bold">
                <div class="flex flex-col lg:flex-row gap-1">
                    <a class="bg-blue-800 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['show' => 'all']) }}">All Items</a>
                    <a class="bg-amber-700 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['show' => 'completed']) }}">Completed</a>
                    <a class="bg-amber-600 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['show' => 'uncompleted']) }}">Uncompleted</a>
                    <a class="bg-red-600 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['show' => 'archived']) }}">Archived</a>
                </div>
                <div class="flex flex-col lg:flex-row gap-1">
                    <a class="bg-blue-800 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}">Sort ASC</a>
                    <a class="bg-amber-700 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}">Sort DESC</a>
                </div>
            </div>

            @foreach ($todoItems as $todoItem)
                @if(!$todoItem->archived)
                    <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                        <div class="flex flex-row items-center">
                            <form method="POST" action="{{ route('todo.toggle', $todoItem) }}">
                                @csrf
                                @method('put')
                                <button
                                    type="submit" @class(['p-1 rounded-sm font-bold font-mono', 'bg-gray-500' => $todoItem->completed, 'bg-gray-700' => !$todoItem->completed])>{{ $todoItem->completed ? "Y" : "N"  }}</button>
                            </form>
                            <p @class(['px-2', 'line-through' => $todoItem->completed])>{{ $todoItem->message }}</p>
                        </div>
                        <div class="flex flex-row gap-2">
                            <a href="{{route('todo.edit', ['item_id' => $todoItem->id])}}"
                               class="bg-emerald-600 p-1 rounded-sm font-bold">Edit</a>
                            <form method="POST" action="{{ route('todo.archive', $todoItem) }}">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        class="bg-red-400 p-1 rounded-sm font-bold">{{ __('Archive') }}</button>
                            </form>
                        </div>
                    </div>
                @endif
                @if($todoItem->archived)
                    <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                        <p @class(['px-2', 'line-through' => $todoItem->completed])>{{ $todoItem->message }}</p>
                        <div class="flex flex-row gap-2">

                            <form method="post" action="{{ route('archive.restore', $todoItem) }}">
                                @method('put')
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 p-1 rounded-sm font-bold">{{ __('Restore') }}</button>
                            </form>

                            <form method="POST" action="{{ route('archive.delete', $todoItem) }}">
                                @method('delete')
                                @csrf
                                <button type="submit"
                                        class="bg-red-400 p-1 rounded-sm font-bold">{{ __('Delete') }}</button>
                            </form>

                        </div>
                    </div>
                @endif
            @endforeach

            @if($itemCounts['total'] === 0)
                <div class="text-white flex flex-row justify-between"><p>This list is empty.</p>
                    <form action="{{ route('lists.delete', ['list_id'=>request()->list_id]) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="rounded-sm p-2 bg-red-600 hover:brightness-110 font-bold">Delete List</button>
                    </form>
                </div>
            @endif

            @if($view !== 'archived' && $itemCounts['total'] === $itemCounts['archived'] && !$itemCounts['total'] === 0)
                <div class="text-white flex flex-row justify-between"><p>This list is empty.</p>
                    <a href="{{ request()->fullUrlWithQuery(['show' => 'archived'])  }}" class="rounded-sm p-2
                    bg-red-600 hover:brightness-110 font-bold">Goto Archive</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
