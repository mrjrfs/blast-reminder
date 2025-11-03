<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function create(Event $event)
    {
        return view('participants.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $event->participants()->create($validated);

        return redirect()->route('events.show', $event)->with('success', 'Partisipan berhasil ditambahkan.');
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $participant->update($validated);

        return redirect()->route('events.show', $participant->event)->with('success', 'Partisipan berhasil diperbarui.');
    }

    public function destroy(Participant $participant)
    {
        $event = $participant->event;
        $participant->delete();

        return redirect()->route('events.show', $event)->with('success', 'Partisipan berhasil dihapus.');
    }
}
