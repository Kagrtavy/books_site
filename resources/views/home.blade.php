<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-5 gap-4"> <!-- Додано 5 колонок -->
                    @foreach ($publications as $publication)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md book-card">
                            <img src="{{ asset('storage/' . $publication->photo) }}"
                                 alt="{{ $publication->name }}"
                                 class="w-full h-48 object-cover rounded-md">
                            <h3 class="mt-4 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ $publication->name }}
                            </h3>
                            <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                Rating: {{ $publication->rating->name }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
