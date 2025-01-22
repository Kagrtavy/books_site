<x-app-layout :title="$chapter->title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $chapter->title }}
        </h2>
    </x-slot>

    <!-- Back Button -->
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
            Back to Chapters
        </a>
    </div>

    <!-- Chapter Text -->
    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
            <pre class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-200">
                {{ $text }}
            </pre>
        </div>
    </div>
</x-app-layout>
