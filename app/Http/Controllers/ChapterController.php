<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Publication;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreChapterRequest;
use Illuminate\Support\Facades\Storage;

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

    public function store(StoreChapterRequest $request, Publication $work)
    {
        $validated = $request->validated();
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

    public function destroy(Chapter $chapter)
    {
        $this->authorize('delete', $chapter);
        if ($chapter->text && Storage::disk('public')->exists($chapter->text)) {
            Storage::disk('public')->delete($chapter->text);
        }
        $chapter->delete();
        return redirect()->back();
    }
}
