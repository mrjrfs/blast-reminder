@extends('layouts.app')

@section('title', 'Edit Partisipan')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Partisipan</h2>

    <form action="{{ route('participants.update', $participant) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $participant->name }}">
        </div>
        <div class="mb-4">
            <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
            <input type="text" id="phone_number" name="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $participant->phone_number }}">
        </div>

        <div class="mb-6">
            <label for="payment_status" class="block text-sm font-semibold text-gray-700 mb-2">Status Pembayaran</label>
            <select id="payment_status" name="payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="unpaid" {{ $participant->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="paid" {{ $participant->payment_status === 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">Simpan Perubahan</button>
            <a href="{{ route('events.show', $participant->event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
