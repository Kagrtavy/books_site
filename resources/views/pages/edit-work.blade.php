<x-app-layout :title="'Edit Work: ' . $work->name">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Work') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <form action="{{ route('works.update', $work->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Work Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $work->name) }}" required
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description"
                          class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ old('description', $work->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rating -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                <select name="rating_id"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    @foreach ($ratings as $rating)
                        <option value="{{ $rating->id }}" {{ $work->rating_id == $rating->id ? 'selected' : '' }}>
                            {{ $rating->name }}
                        </option>
                    @endforeach
                </select>
                @error('rating_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    <option value="In progress" {{ $work->status === 'In progress' ? 'selected' : '' }}>In progress</option>
                    <option value="Completed" {{ $work->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Frozen" {{ $work->status === 'Frozen' ? 'selected' : '' }}>Frozen</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Save Changes
            </button>
        </form>
    </div>
</x-app-layout>
