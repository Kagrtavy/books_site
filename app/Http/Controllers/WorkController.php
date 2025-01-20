<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Rating;
use App\Models\Source;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function create()
    {
        $sources = Source::all();
        $ratings = Rating::all();
        return view('pages.add-work', compact('sources', 'ratings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:Original work,Based on',
            'authorship' => 'required|in:The work of your authorship,Translation',
            'author' => 'nullable|string|max:150',
            'work_link' => 'nullable|url|max:255',
            'source_id' => 'nullable',
            'new_source' => 'nullable|string|max:255|required_if:source_id,new',
            'rating_id' => 'required|exists:ratings,id',
            'status' => 'required|in:In progress,Completed,Frozen',
            'size' => 'required|in:min,mid,max',
            'description' => 'nullable|string',
        ]);
        if ($validated['source_id'] === 'new' && !empty($validated['new_source'])) {
            $source = Source::create(['name' => $validated['new_source']]);
            $validated['source_id'] = $source->id;
        }
        if (empty($validated['source_id'])) {
            return back()->withErrors(['source_id' => 'Please select or add a source.'])->withInput();
        }
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images/bookCovers', 'public');
        } else {
            $validated['photo'] = 'images/defaultCover/default.jpg';
        }
        $validated['user_id'] = auth()->id();
        $work = Publication::create($validated);
        $workDirectory = storage_path('app/public/works/' . $work->name);
        if (!file_exists($workDirectory)) {
            mkdir($workDirectory, 0755, true);
        }
        return redirect()->route('chapters.create', $work);
    }
}
