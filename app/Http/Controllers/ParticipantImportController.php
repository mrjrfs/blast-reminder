<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ParticipantImport;
use App\Services\ExcelImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantImportController extends Controller
{
    public function create(Event $event)
    {
        return view('participants.import', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('imports', 'public');
            $fullPath = storage_path('app/public/' . $path);

            $service = new ExcelImportService();
            $import = $service->import($fullPath, $event, Auth::id());

            // Clean up file
            @unlink($fullPath);

            return redirect()
                ->route('events.show', $event->id)
                ->with('success', "Import completed! Imported {$import->imported_rows} participants.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function history(Event $event)
    {
        $imports = ParticipantImport::where('event_id', $event->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('participants.import-history', compact('event', 'imports'));
    }

    public function show(ParticipantImport $import)
    {
        return view('participants.import-detail', compact('import'));
    }
}
