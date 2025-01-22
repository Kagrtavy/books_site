<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Rating;
use App\Models\Source;
use Illuminate\Http\Request;
use App\Models\Genre;

class WorkController extends Controller
{
    public function create()
    {
        $sources = Source::all();
        $ratings = Rating::all();
        $genres = Genre::all();
        return view('pages.add-work', [
            'sources' => $sources,
            'ratings' => $ratings,
            'genres' => $genres
        ]);
    }

    public function show(Publication $work)
    {
        return view('pages.work', [
            'work' => $work
        ]);
    }

    public function store(Request $request)
    {
        $this->handleGenres($request);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:Original work,Based on',
            'authorship' => 'required|in:The work of your authorship,Translation',
            'author' => 'nullable|string|max:150',
            'work_link' => 'nullable|url|max:255',
            'source_id' => 'nullable',
            'new_source' => 'nullable|string|max:255|required_if:source_id,new',
            'genres' => 'required|array|exists:genres,id',
            'rating_id' => 'required|exists:ratings,id',
            'status' => 'required|in:In progress,Completed,Frozen',
            'size' => 'required|in:min,mid,max',
            'description' => 'nullable|string',
        ]);
        $this->handleSource($validated);
        $this->handlePhoto($request, $validated);
        $validated['user_id'] = auth()->id();
        $work = Publication::create($validated);
        if ($request->has('genres')) {
            $work->genres()->attach($validated['genres']);
        }
        $this->createWorkDirectory($work->name);
        return redirect()->route('chapters.create', $work);
    }

    protected function handleGenres(Request $request)
    {
        if (is_string($request->genres)) {
            $request->merge([
                'genres' => json_decode($request->genres, true),
            ]);
        }
    }

    private function handleSource(array &$validated)
    {
        if ($validated['source_id'] === 'new' && !empty($validated['new_source'])) {
            $source = Source::create(['name' => $validated['new_source']]);
            $validated['source_id'] = $source->id;
        }
    }

    private function handlePhoto(Request $request, array &$validated)
    {
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images/bookCovers', 'public');
        } else {
            $validated['photo'] = 'images/defaultCover/default.jpg';
        }
    }

    private function createWorkDirectory(string $workName)
    {
        $workDirectory = storage_path('app/public/works/' . $workName);
        if (!file_exists($workDirectory)) {
            mkdir($workDirectory, 0755, true);
        }
    }
}
