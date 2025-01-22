<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Publication;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\UploadedFile;

class ChapterController extends Controller
{
    public function create(Publication $work)
    {
        $chapters = $work->chapters;

        return view('pages.add-chapter', [
            'work' => $work,
            'chapters' => $chapters,
        ]);
    }

    public function store(Request $request, Publication $work)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'file' => 'required|mimes:docx|max:10240',
        ]);
        $fileName = $this->generateFileName($validated['name'], $request->file('file'));
        $filePath = $this->saveChapterFile($request->file('file'), $fileName, $work->name);
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
        $text = $this->getChapterText($filePath);
        return view('pages.chapter-text', [
            'chapter' => $chapter,
            'text' => $text
        ]);
    }

    function generateFileName(string $originalName, UploadedFile $file): string
    {
        $cleanedName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $originalName);
        $fileExtension = $file->getClientOriginalExtension();
        return $cleanedName . '.' . $fileExtension;
    }

    protected function saveChapterFile(UploadedFile $file, string $fileName, string $workName): string
    {
        $chapterDirectory = 'works/' . $workName;
        return $file->storeAs($chapterDirectory, $fileName, 'public');
    }

    protected function getChapterText(string $filePath): string
    {
        $phpWord = IOFactory::load($filePath);
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }
        return $text;
    }
}
