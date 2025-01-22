<div class="mt-4">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Chapters:</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @forelse ($chapters as $chapter)
            <a href="{{ route('chapter.show', $chapter) }}"
               class="block bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md hover:bg-gray-100 dark:hover:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $chapter->name }}</h3>
            </a>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No chapters available for this work.</p>
        @endforelse
    </div>
</div>
