@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h2 class="text-3xl font-bold">{{ $event->title }}</h2>
            <p class="text-gray-600 mt-2">{{ $event->description }}</p>
            <p class="text-gray-700 mt-2"><strong>Tanggal:</strong> {{ $event->event_date->format('d-m-Y H:i') }}</p>
            <p class="text-gray-700"><strong>Status:</strong> <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">{{ ucfirst($event->status) }}</span></p>
        </div>
        <a href="{{ route('events.edit', $event) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Participants Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Partisipan ({{ $event->participants->count() }})</h3>
            <div class="flex gap-2">
                <a href="{{ route('participants.import.create', $event) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded">Import Excel</a>
                <a href="{{ route('events.participants.create', $event) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded">+ Tambah</a>
            </div>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto">
            @forelse ($participants as $participant)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div>
                        <p class="font-semibold">{{ $participant->name }}</p>
                        <p class="text-sm text-gray-600">{{ $participant->email }}</p>
                        <span class="text-xs px-2 py-1 rounded {{ $participant->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($participant->payment_status) }}
                        </span>
                    </div>
                    <div class="flex gap-1">
                        <a href="{{ route('participants.edit', $participant) }}" class="text-blue-500 hover:underline text-sm">Edit</a>
                        <form action="{{ route('participants.destroy', $participant) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Tidak ada partisipan</p>
            @endforelse
        </div>
        <div class="mt-4 flex gap-2">
            {{ $participants->links() }}
            <a href="{{ route('participants.import.history', $event) }}" class="text-blue-500 hover:underline text-sm">Lihat Riwayat Import</a>
        </div>
    </div>

    <!-- Reminders Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Reminder ({{ $event->scheduledReminders->count() }})</h3>
            <a href="{{ route('reminders.create', ['event' => $event->id]) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded">+ Buat</a>
        </div>
        <div class="space-y-2 max-h-96 overflow-y-auto">
            @forelse ($reminders as $reminder)
                <div class="p-3 bg-gray-50 rounded border-l-4 {{ $reminder->is_active ? 'border-green-500' : 'border-gray-300' }}">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-semibold text-sm">{{ ucfirst(str_replace('_', ' ', $reminder->type)) }}</p>
                            <p class="text-xs text-gray-600 mt-1">Target: <strong>{{ ucfirst($reminder->target_status) }}</strong></p>
                            <p class="text-xs text-gray-600">Schedule: <strong>{{ $reminder->schedule_setting }}</strong></p>
                            <p class="text-xs mt-2 line-clamp-2">{{ $reminder->message_template }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <a href="{{ route('reminders.edit', $reminder) }}" class="text-blue-500 hover:underline text-xs">Edit</a>
                            <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Tidak ada reminder</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
</merged_code
