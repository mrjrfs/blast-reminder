@extends('layouts.app')

@section('title', 'Riwayat Import Partisipan')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Riwayat Import Partisipan: {{ $event->title }}</h2>
        <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
    </div>

    @if($imports->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Belum ada riwayat import</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($imports as $import)
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-semibold text-lg">{{ $import->file_name }}</p>
                            <p class="text-sm text-gray-600">{{ $import->created_at->format('d-m-Y H:i:s') }}</p>
                            <p class="text-sm text-gray-600">Oleh: {{ $import->user->name }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ 
                            $import->status === 'completed' ? 'bg-green-100 text-green-800' : 
                            ($import->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                            ($import->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                        }}">
                            {{ ucfirst($import->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Baris</p>
                            <p class="text-2xl font-bold">{{ $import->total_rows }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Berhasil</p>
                            <p class="text-2xl font-bold text-green-600">{{ $import->imported_rows }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Gagal</p>
                            <p class="text-2xl font-bold text-red-600">{{ $import->failed_rows }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Persentase</p>
                            <p class="text-2xl font-bold">{{ $import->total_rows > 0 ? round(($import->imported_rows / $import->total_rows) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    @if($import->error_message)
                        <div class="bg-red-50 border border-red-200 rounded p-3 mb-4">
                            <p class="text-sm text-red-800"><strong>Error:</strong> {{ $import->error_message }}</p>
                        </div>
                    @endif

                    @if($import->failed_data)
                        <div class="flex items-center">
                            <a href="{{ route('participants.import.show', $import) }}" class="text-blue-500 hover:underline text-sm">
                                Lihat Detail Kegagalan ({{ $import->failed_rows }} baris)
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $imports->links() }}
        </div>
    @endif
</div>
@endsection
