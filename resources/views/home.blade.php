<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-end">
            <a href="{{ route('works.create') }}"
               class="px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Add work
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-5 gap-4">
                    @foreach ($publications as $publication)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md book-card">
                            <img src="{{ asset('storage' . DIRECTORY_SEPARATOR . $publication->photo) }}"
                                 alt="{{ $publication->name }}"
                                 class="w-full h-48 object-cover rounded-md book-cover">
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
