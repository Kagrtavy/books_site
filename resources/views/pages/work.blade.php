<x-app-layout :title="$work->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $work->name }}
        </h2>
    </x-slot>

    <!-- Back Button -->
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('home') }}"
           class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
            Back
        </a>
    </div>

    <!-- Information about the work -->
    <div class="py-4" style="padding-bottom: 0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="flex-1">
                        <ul class="list-none space-y-2">
                            <li><strong>Added by:</strong>
                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $work->user->name ?? 'Unknown User' }}
                                </span>
                            </li>
                            <li><strong>Type:</strong> {{ $work->type }}</li>
                            @if ($work->type === 'Based on' && $work->source)
                                <li><strong>Source:</strong> {{ $work->source->name }}</li>
                            @endif
                            @if ($work->genres->isNotEmpty())
                                <li>
                                    <strong>Genres:</strong>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach ($work->genres as $genre)
                                            <span class="bg-blue-100 dark:bg-blue-700 text-blue-900 dark:text-blue-200 px-3 py-1 rounded-lg text-sm">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                            <li><strong>Authorship:</strong> {{ $work->authorship }}</li>
                            @if ($work->author)
                                <li><strong>Author:</strong> {{ $work->author }}</li>
                            @endif
                            @if ($work->work_link)
                                <li><strong>Original Link:</strong>
                                    <a href="{{ $work->work_link }}" class="text-blue-500 hover:underline" target="_blank">
                                        {{ $work->work_link }}
                                    </a>
                                </li>
                            @endif
                            <li><strong>Rating:</strong> {{ $work->rating->name }}</li>
                            <li><strong>Size:</strong> {{ $work->size }}</li>
                        </ul>
                    </div>
                    <div>
                        <img src="{{ asset('storage' . DIRECTORY_SEPARATOR . $work->photo) }}"
                             alt="{{ $work->name }}"
                             class="w-64 h-80 object-cover rounded-lg shadow-md">
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Description:</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $work->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Displaying chapters -->
    <div class="mt-4 mb-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @include('pages.chapter-list', ['chapters' => $work->chapters])
    </div>
</x-app-layout>
