@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm font-semibold">Total Acara</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ Auth::user()->events->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm font-semibold">Total Partisipan</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ Auth::user()->events->flatMap->participants->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm font-semibold">Pembayaran Pending</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ Auth::user()->events->flatMap->participants->where('payment_status', 'unpaid')->count() }}</p>
    </div>
</div>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Daftar Acara</h2>
    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Buat Acara Baru</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Judul Acara</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Partisipan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->events as $event)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $event->title }}</td>
                    <td class="px-6 py-3">{{ $event->event_date->format('d-m-Y H:i') }}</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3">{{ $event->participants->count() }}</td>
                    <td class="px-6 py-3 space-x-2">
                        <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:underline">Detail</a>
                        <a href="{{ route('events.edit', $event) }}" class="text-yellow-500 hover:underline">Edit</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus acara ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
