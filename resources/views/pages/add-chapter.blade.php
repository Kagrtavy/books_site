<x-app-layout :title="'Add Chapters | ' . $work->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Chapters for: ') . $work->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Button Add Chapter -->
            <div class="mb-4 text-right">
                <button id="add-chapter-btn"
                        class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                    Add Chapter
                </button>
            </div>

            <!-- Form for adding a chapter -->
            <div id="chapter-form" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 hidden">
                <form action="{{ route('chapters.store', $work) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chapter Name</label>
                        <input type="text" name="name" id="name"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- .docx -->
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Chapter (.docx)</label>
                        <input type="file" name="file" id="file" accept=".docx"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        @error('file')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Save -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                            Save Chapter
                        </button>
                    </div>
                </form>
            </div>

            <!-- List of chapters -->
            <div id="chapters-list">
                @foreach ($chapters as $chapter)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $chapter->name }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">File: {{ basename($chapter->text) }}</p>

                        <!-- Delete Button -->
                        <form action="{{ route('chapters.destroy', $chapter) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this chapter?');" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Save button -->
            <div class="text-right mt-6">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                    Save
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
