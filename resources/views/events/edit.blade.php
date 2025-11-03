@extends('layouts.app')

@section('title', 'Edit Acara')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Acara</h2>

    <form action="{{ route('events.update', $event) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Acara</label>
            <input type="text" id="title" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $event->title }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $event->description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu Acara</label>
            <input type="datetime-local" id="event_date" name="event_date" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $event->event_date->format('Y-m-d\TH:i') }}">
        </div>

        <div class="mb-6">
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="upcoming" {{ $event->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">Simpan Perubahan</button>
            <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
