<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Rating;
use App\Models\Source;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;

class WorkController extends Controller
{
    /**
     * shows form for new work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
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

    /**
     * shows work page
     * @param Publication $work
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Publication $work, Request $request)
    {
        $redirect = $request->query('redirect', 'home');
        return view('pages.work', [
            'work' => $work,
            'redirect' => $redirect
        ]);
    }

    /**
     * stores work
     * @param StoreWorkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreWorkRequest $request)
    {
        $validated = $request->validated();
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

    /**
     * choosing or adding source
     * @param array $validated
     * @return void
     */
    private function handleSource(array &$validated)
    {
        if ($validated['source_id'] === 'new' && !empty($validated['new_source'])) {
            $source = Source::create(['name' => $validated['new_source']]);
            $validated['source_id'] = $source->id;
        }
    }

    /**
     * adds photo for work
     * @param Request $request
     * @param array $validated
     * @return void
     */
    private function handlePhoto(Request $request, array &$validated)
    {
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images/bookCovers', 'public');
        } else {
            $validated['photo'] = 'images/defaultCover/default.jpg';
        }
    }

    /**
     * creates directory for specific work
     * @param string $workName
     * @return void
     */
    private function createWorkDirectory(string $workName)
    {
        $workDirectory = storage_path('app/public/works/' . $workName);
        if (!file_exists($workDirectory)) {
            mkdir($workDirectory, 0755, true);
        }
    }

    /**
     * shows edit page for work
     * @param Publication $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(Publication $work)
    {
        $sources = Source::all();
        $ratings = Rating::all();
        return view('pages.edit-work', [
            'work' => $work,
            'sources' => $sources,
            'ratings' => $ratings
        ]);
    }

    /**
     * changes some work info
     * @param UpdateWorkRequest $request
     * @param Publication $work
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateWorkRequest  $request, Publication $work)
    {
        $validated = $request->validated();
        $work->update($validated);
        return redirect()->route('user.works');
    }

    /**
     * deletes work
     * @param Publication $work
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Publication $work)
    {
        $work->chapters()->delete();
        $work->delete();
        return redirect()->route('user.works');
    }
}
