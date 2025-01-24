<x-app-layout :title="'Author Page'">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <h1 class="text-2xl font-bold mb-4">Your Works</h1>

        @if ($works->isEmpty())
            <p class="text-gray-500">You haven't added any works yet.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($works as $work)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                        <h2 class="text-lg font-semibold">{{ $work->name }}</h2>
                        <p class="text-sm text-gray-500">
                            Created on: {{ $work->created_at->format('d M, Y') }}
                        </p>
                        <p class="mt-2 text-gray-700 dark:text-gray-300">
                            {{ Str::limit($work->description, 100, '...') }}
                        </p>
                        <div class="flex justify-between items-center mt-4">
                            <a href="{{ route('works.show', ['work' => $work->id, 'redirect' => 'user.works']) }}"
                               class="text-blue-500 hover:underline">
                                View Work
                            </a>
                            <a href="{{ route('works.edit', $work->id) }}"
                               class="text-yellow-500 hover:underline">
                                Edit
                            </a>
                            <form action="{{ route('works.destroy', $work->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this work? This will also delete all its chapters.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
