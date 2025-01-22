<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Publication;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;

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

    public function show(Chapter $chapter)
    {
        $filePath = storage_path('app/public/' . $chapter->text);

        if (!file_exists($filePath)) {
            abort(404, 'Chapter file not found.');
        }

        $phpWord = IOFactory::load($filePath);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }

        return view('pages.chapter-text', ['chapter' => $chapter, 'text' => $text]);
    }
}
