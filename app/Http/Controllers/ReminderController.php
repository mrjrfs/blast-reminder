<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ScheduledReminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{

    public function create(Request $request)
    {
        $event = Event::findOrFail($request->event);

        return view('reminders.create', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message_template' => 'required|string',
            'type' => 'required|in:payment_reminder,event_reminder',
            'schedule_setting' => 'required|string',
        ]);

        $event = Event::findOrFail($request->event);

        $event->scheduledReminders()->create($validated);

        return redirect()->route('events.show', $event)->with('success', 'Reminder berhasil dibuat.');
    }

    public function edit(ScheduledReminder $reminder)
    {
        $event = $reminder->event;
        return view('reminders.edit', compact('reminder', 'event'));
    }

    public function update(Request $request, ScheduledReminder $reminder)
    {

        $validated = $request->validate([
            'message_template' => 'required|string',
            'type' => 'required|in:payment_reminder,event_reminder',
            'schedule_setting' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $reminder->update($validated);

        return redirect()->route('events.show', $reminder->event)->with('success', 'Reminder berhasil diperbarui.');
    }

    public function destroy(ScheduledReminder $reminder)
    {
        $event = $reminder->event;
        $reminder->delete();

        return redirect()->route('events.show', $event)->with('success', 'Reminder berhasil dihapus.');
    }
}
