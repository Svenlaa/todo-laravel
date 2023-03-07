<x-app-layout>
    <form method="POST" action="{{ route('todo-items.store') }}">
        @csrf
        <input type="string" name="message" />

        <x-primary-button class="bg-green-700 text-white">{{ __('Add') }}</x-primary-button>
    </form>
    @foreach ($todoItems as $todoItem)
        <p class="text-red-500 bg-black">{{ $todoItem->message }}</p>
    @endforeach
</x-app-layout>