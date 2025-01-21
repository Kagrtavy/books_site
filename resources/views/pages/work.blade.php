<x-app-layout :title="$work->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $work->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('storage' . DIRECTORY_SEPARATOR . $work->photo) }}" alt="{{ $work->name }}"
                         class="w-48 h-64 object-cover rounded-lg">
                    <h3 class="mt-6 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $work->name }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $work->description }}</p>
                </div>
                <div class="mt-6">
                    <ul class="list-disc list-inside">
                        <li><strong>Type:</strong> {{ $work->type }}</li>
                        @if ($work->source)
                            <li><strong>Source:</strong> {{ $work->source->name }}</li>
                        @endif
                        <li><strong>Authorship:</strong> {{ $work->authorship }}</li>
                        @if ($work->author)
                            <li><strong>Author:</strong> {{ $work->author }}</li>
                        @endif
                        @if ($work->work_link)
                            <li><strong>Original Link:</strong> <a href="{{ $work->work_link }}" class="text-blue-500 hover:underline" target="_blank">{{ $work->work_link }}</a></li>
                        @endif
                        <li><strong>Rating:</strong> {{ $work->rating->name }}</li>
                        <li><strong>Size:</strong> {{ $work->size }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
