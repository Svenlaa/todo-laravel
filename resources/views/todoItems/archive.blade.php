<x-app-layout>
    <div class="w-1/2 mx-auto flex-col flex p-8">
        <div class="flex flex-col gap-4 w-4/5 mx-auto py-4">
            @foreach ($todoItems as $todoItem)
                <div class="flex bg-gray-800 p-2 rounded-sm justify-between items-center text-white">
                    <p>{{ $todoItem->message }}</p>
                    <div class="flex flex-row gap-2">

                        <form method="POST" action="{{ route('archive.restore', $todoItem) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 p-1 rounded-sm font-bold">{{ __('Restore') }}</button>
                        </form>

                        <form method="POST" action="{{ route('archive.delete', $todoItem) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="bg-red-400 p-1 rounded-sm font-bold">{{ __('Delete') }}</button>
                        </form>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
