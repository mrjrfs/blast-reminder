@extends('layouts.app')

@section('title', 'Edit Reminder')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Reminder</h2>

    <form action="{{ route('reminders.update', $reminder) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Reminder</label>
            <select id="type" name="type" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="payment_reminder" {{ $reminder->type === 'payment_reminder' ? 'selected' : '' }}>Reminder Pembayaran</option>
                <option value="event_reminder" {{ $reminder->type === 'event_reminder' ? 'selected' : '' }}>Reminder Acara</option>
            </select>
        </div>

        <!-- Removed target_status field - reminders send to all participants -->
        <div class="mb-4 p-3 bg-blue-50 rounded border border-blue-200">
            <p class="text-sm text-blue-800">
                <strong>Info:</strong> Reminder ini akan dikirim ke <strong>semua partisipan</strong> melalui WhatsApp berdasarkan nomor HP mereka.
            </p>
        </div>

        <div class="mb-4">
            <label for="schedule_setting" class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Pengiriman</label>
            <input type="text" id="schedule_setting" name="schedule_setting" placeholder="Contoh: H-3, H-1, H-0" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $reminder->schedule_setting }}">
        </div>

        <div class="mb-4">
            <label for="message_template" class="block text-sm font-semibold text-gray-700 mb-2">Pesan Template</label>
            <textarea id="message_template" name="message_template" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $reminder->message_template }}</textarea>
        </div>

        <div class="mb-6">
            <label for="is_active" class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ $reminder->is_active ? 'checked' : '' }} class="rounded">
                <span class="ml-2 text-sm font-semibold text-gray-700">Aktifkan Reminder</span>
            </label>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">Simpan Perubahan</button>
            <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
