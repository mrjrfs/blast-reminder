<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Auth::user()->events()->latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after:now',
        ]);

        Auth::user()->events()->create($validated);

        return redirect()->route('events.index')->with('success', 'Acara berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $participants = $event->participants()->latest()->paginate(10);
        $reminders = $event->scheduledReminders;

        return view('events.show', compact('event', 'participants', 'reminders'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'status' => 'required|in:upcoming,completed',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Acara berhasil dihapus.');
    }
}
