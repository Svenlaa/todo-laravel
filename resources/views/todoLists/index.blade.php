<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo Lists') }}
        </h2>
    </x-slot>

    <div class="w-1/2 mx-auto flex-col flex p-8">
        <form method="POST" action="{{ route('lists.store') }}"
              class="w-full p-4 rounded-md bg-gray-700 flex flex-row justify-between gap-2">
            @csrf
            <input type="text" name="name" class="w-full p-2 rounded-sm"
                   placeholder="What should your list be called?"/>

            <x-primary-button class="bg-green-700 text-white">{{ __('Add') }}</x-primary-button>
        </form>

        <div class="flex flex-col gap-4 w-4/5 mx-auto py-4">

            @foreach ($todoLists as $todoList)
                <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                    <a href="{{ route('lists.show', ['list_id' => $todoList->id]) }}"
                       class="flex flex-row items-center">
                        <p class="px-2">{{ $todoList->name }}</p>
                    </a>
                    <a class="bg-green-600 p-1 rounded-sm font-bold"
                       href="{{route('lists.edit', $todoList)}}">Edit</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
