<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Publication;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function create(Publication $work)
    {
        $chapters = $work->chapters;

        return view('pages.add-chapter', compact('work', 'chapters'));
    }

    public function store(Request $request, Publication $work)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'file' => 'required|mimes:docx|max:10240',
        ]);
        $cleanedName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $validated['name']);
        $fileExtension = $request->file('file')->getClientOriginalExtension();
        $fileName = $cleanedName . '.' . $fileExtension;
        $chapterDirectory = 'works/' . $work->name;
        $filePath = $request->file('file')->storeAs($chapterDirectory, $fileName, 'public');
        Chapter::create([
            'name' => $validated['name'],
            'text' => $filePath,
            'publication_id' => $work->id,
        ]);
        return redirect()->route('chapters.create', $work);
    }
}
