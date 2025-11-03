@extends('layouts.app')

@section('title', 'Buat Reminder')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Buat Reminder untuk: {{ $event->title }}</h2>

    <form action="{{ route('reminders.store', ['event' => $event->id]) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Reminder</label>
            <select id="type" name="type" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="payment_reminder">Reminder Pembayaran</option>
                <option value="event_reminder">Reminder Acara</option>
            </select>
        </div>

        <!-- Removed target_status field - reminders now send to all participants -->
        <div class="mb-4 p-3 bg-blue-50 rounded border border-blue-200">
            <p class="text-sm text-blue-800">
                <strong>Info:</strong> Reminder ini akan dikirim ke <strong>semua partisipan</strong> melalui WhatsApp berdasarkan nomor HP mereka.
            </p>
        </div>

        <div class="mb-4">
            <label for="schedule_setting" class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Pengiriman</label>
            <input type="text" id="schedule_setting" name="schedule_setting" placeholder="Contoh: H-3, H-1, H-0" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('schedule_setting') }}">
            <p class="text-xs text-gray-500 mt-1">H-3 berarti 3 jam sebelum acara dimulai, H-1 berarti 1 jam sebelum acara, H-0 berarti tepat saat acara dimulai</p>
        </div>

        <div class="mb-6">
            <label for="message_template" class="block text-sm font-semibold text-gray-700 mb-2">Pesan Template</label>
            <textarea id="message_template" name="message_template" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Gunakan placeholder: {participant_name}, {event_title}, {event_date}">{{ old('message_template') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Contoh: Halo {participant_name}, jangan lupa acara {event_title} akan dimulai pada {event_date}. Sampai jumpa!</p>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">Buat Reminder</button>
            <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
