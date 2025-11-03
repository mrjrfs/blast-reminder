@extends('layouts.app')

@section('title', 'Daftar Acara')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Daftar Acara</h2>
    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Buat Acara Baru</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Judul</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Partisipan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($events as $event)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3 font-semibold">{{ $event->title }}</td>
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
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada acara. <a href="{{ route('events.create') }}" class="text-blue-500 hover:underline">Buat sekarang</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $events->links() }}
</div>
@endsection
