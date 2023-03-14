<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo Lists') }}
        </h2>
    </x-slot>

    <div class="w-1/2 mx-auto flex-col flex p-8">
        <form method="POST"
              action="{{ route('lists.update', ['list_id' => request()->list_id]) }}"
              class="w-full p-4 rounded-md bg-gray-700 flex flex-row justify-between gap-2">
            @csrf
            @method('patch')
            <input type="text" name="name" class="w-full p-2 rounded-sm"
                   placeholder="What should your list be called?" value="{{$todoList->name}}"/>

            <x-primary-button class="bg-green-700 text-white">{{ __('Add') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
