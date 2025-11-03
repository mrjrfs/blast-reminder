@extends('layouts.app')

@section('title', 'Detail Import - Kegagalan')

@section('content')
<div>
    <div class="mb-6">
        <a href="{{ route('participants.import.history', $import->event) }}" class="text-blue-500 hover:underline">← Kembali ke Riwayat Import</a>
        <h2 class="text-2xl font-bold mt-4">Detail Kegagalan Import: {{ $import->file_name }}</h2>
        <p class="text-gray-600 mt-2">Total Gagal: <strong>{{ $import->failed_rows }}</strong> dari <strong>{{ $import->total_rows }}</strong> baris</p>
    </div>

    @if($import->failed_data)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4 text-left">Baris</th>
                        <!-- Updated columns to show Name and Phone Number -->
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">No HP</th>
                        <th class="p-4 text-left">Error</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($import->failed_data as $failure)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                <span class="text-red-600 font-semibold">#{{ $failure['row'] }}</span>
                            </td>
                            <td class="p-4">{{ $failure['data'][0] ?? '-' }}</td>
                            <td class="p-4">{{ $failure['data'][1] ?? '-' }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                    {{ $failure['error'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded border border-blue-200">
            <p class="text-sm text-blue-800">
                <strong>Saran:</strong> Periksa kolom yang bercetak merah, perbaiki data, dan coba import ulang.
            </p>
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Tidak ada data kegagalan yang tersimpan</p>
        </div>
    @endif
</div>
@endsection
