@extends('layouts.app')

@section('title', 'Tambah Partisipan')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Tambah Partisipan ke: {{ $event->title }}</h2>

    <form action="{{ route('events.participants.store', $event) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}">
        </div>
        <div class="mb-6">
            <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
            <input type="text" id="phone_number" required name="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('phone_number') }}">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">Tambah Partisipan</button>
            <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
