<x-app-layout>
    <div class="w-1/2 mx-auto flex-col flex p-8">
        <form method="POST" action="{{ route('todo-items.store') }}" class="w-full p-4 rounded-md bg-gray-700 flex flex-row justify-between gap-2">
            @csrf
            <input type="text" name="message" class="w-full p-2 rounded-sm" />

        <x-primary-button class="bg-green-700 text-white">{{ __('Add') }}</x-primary-button>
        </form>


        <div class="flex flex-col gap-4 w-4/5 mx-auto py-4">
        @foreach ($todoItems as $todoItem)
                <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                    <p>{{ $todoItem->message }}</p>
                    <form method="POST" action="{{ route('todo-items.destroy', $todoItem) }}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bg-red-400 p-1 rounded-sm font-bold">{{ __('Delete') }}</button>
                    </form>
                </div>
       @endforeach
    </div>
    </div>
</x-app-layout>
