<x-app-layout :title="'Add Work'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Work') }}
        </h2>
    </x-slot>

    <!-- Back Button -->
    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('home') }}"
           class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
            Back
        </a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('works.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" maxlength="100"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <!-- Photo -->
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 dark:file:border-gray-600 file:bg-gray-100 dark:file:bg-gray-700">
                        <!-- Попередній перегляд -->
                        <div id="photo-preview" class="mt-4">
                            <img src="" alt="Preview" class="rounded-md shadow-md hidden preview-image" id="photo-preview-img">
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                        <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <option value="Original work">Original work</option>
                            <option value="Based on">Based on</option>
                        </select>
                    </div>

                    <!-- Source -->
                    <div class="mb-4" id="source-wrapper" style="display: none;">
                        <label for="source_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Source</label>
                        <select name="source_id" id="source_id"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                            <option value="new">Other (Enter a new source)</option>
                        </select>
                    </div>

                    <!-- New Source -->
                    <div class="mb-4" id="new-source-wrapper" style="display: none;">
                        <label for="new_source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Source</label>
                        <input type="text" name="new_source" id="new_source"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <!-- Поле вибору жанрів -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Select Genres
                        </label>
                        <div class="border border-gray-300 dark:border-gray-600 rounded-md p-2">
                            <div id="selected-genres" class="flex flex-wrap gap-2 mb-2">
                                <!-- Тут будуть відображатися вибрані жанри -->
                            </div>
                            <input
                                type="text"
                                id="genre-search"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md"
                                placeholder="Type to search genres"
                                autocomplete="off"
                            />
                            <div id="genre-list" class="mt-2 hidden max-h-40 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                                @foreach ($genres as $genre)
                                    <div
                                        class="genre-item px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700"
                                        data-id="{{ $genre->id }}"
                                        data-name="{{ $genre->name }}">
                                        {{ $genre->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Hidden field for genre transfer -->
                        <input type="hidden" name="genres" id="selected-genre-ids" value="[]">
                    </div>

                    <!-- Authorship -->
                    <div class="mb-4">
                        <label for="authorship" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Authorship</label>
                        <select name="authorship" id="authorship" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <option value="The work of your authorship">The work of your authorship</option>
                            <option value="Translation">Translation</option>
                        </select>
                    </div>

                    <!-- Author -->
                    <div class="mb-4" id="author-wrapper" style="display: none;">
                        <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                        <input type="text" name="author" id="author" maxlength="150"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <!-- Work Link -->
                    <div class="mb-4" id="work-link-wrapper" style="display: none;">
                        <label for="work_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Work Link</label>
                        <input type="url" name="work_link" id="work_link"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <label for="rating_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                        <select name="rating_id" id="rating_id" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            @foreach ($ratings as $rating)
                                <option value="{{ $rating->id }}">{{ $rating->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <option value="In progress">In progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Frozen">Frozen</option>
                        </select>
                    </div>

                    <!-- Size -->
                    <div class="mb-4">
                        <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                        <select name="size" id="size" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <option value="min">Min</option>
                            <option value="mid">Mid</option>
                            <option value="max">Max</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                            Submit
                        </button>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
