<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Archive') }}
        </h2>
    </x-slot>

    <div class="w-1/2 mx-auto flex-col flex p-8">
        <div class="flex flex-col gap-4 w-4/5 mx-auto py-4">
            @foreach ($todoItems as $todoItem)
                <div
                    class="flex bg-white drop-shadow-md dark:bg-gray-800 p-2 rounded-sm justify-between items-center text-gray-800 dark:text-white">
                    <p @class(['px-2', 'line-through' => $todoItem->completed])>{{ $todoItem->message }}</p>
                    <div class="flex flex-row gap-2 text-white">

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
            @endforeach
        </div>
    </div>
</x-app-layout>
