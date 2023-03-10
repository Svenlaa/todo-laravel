<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo List') }}
        </h2>
    </x-slot>

    <div class="w-1/2 mx-auto flex-col flex p-8">
        <form method="POST" action="{{ route('todo-items.store') }}"
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
                </div>
                <div class="flex flex-col lg:flex-row gap-1">
                    <a class="bg-blue-800 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}">Sort ASC</a>
                    <a class="bg-amber-700 p-2 rounded-sm hover:brightness-110"
                       href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}">Sort DESC</a>
                </div>
            </div>

            @foreach ($todoItems as $todoItem)
                <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                    <div class="flex flex-row items-center">
                        <form method="POST" action="{{ route('todo-items.toggle', $todoItem) }}">
                            @csrf
                            @method('put')
                            <button
                                type="submit" @class(['p-1 rounded-sm font-bold font-mono', 'bg-gray-500' => $todoItem->completed, 'bg-gray-700' => !$todoItem->completed])>{{ $todoItem->completed ? "Y" : "N"  }}</button>
                        </form>
                        <p @class(['px-2', 'line-through' => $todoItem->completed])>{{ $todoItem->message }}</p>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('todo-items.archive', $todoItem) }}">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                    class="bg-red-400 p-1 rounded-sm font-bold">{{ __('Archive') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
