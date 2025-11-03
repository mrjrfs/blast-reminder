@extends('layouts.app')

@section('title', 'Import Partisipan dari Excel')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Import Partisipan dari Excel: {{ $event->title }}</h2>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Format File Excel</h3>
        <p class="text-gray-700 mb-3">File Excel harus memiliki kolom berikut di baris pertama (header):</p>
        <table class="w-full text-sm border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-2 text-left">Kolom</th>
                    <th class="border border-gray-300 p-2 text-left">Keterangan</th>
                    <th class="border border-gray-300 p-2 text-left">Wajib</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 p-2">A - Name</td>
                    <td class="border border-gray-300 p-2">Nama partisipan</td>
                    <td class="border border-gray-300 p-2 text-center"><span class="text-red-500 font-bold">✓</span></td>
                </tr>
                <tr class="bg-gray-50">
                    <!-- Updated from Email to Phone Number -->
                    <td class="border border-gray-300 p-2">B - Phone Number</td>
                    <td class="border border-gray-300 p-2">No HP partisipan (08xxx atau +628xxx)</td>
                    <td class="border border-gray-300 p-2 text-center"><span class="text-red-500 font-bold">✓</span></td>
                </tr>
            </tbody>
        </table>
        <p class="text-gray-600 text-sm mt-4 p-3 bg-blue-50 rounded border border-blue-200">
            <strong>Contoh format:</strong> Nama partisipan di kolom A, No HP di kolom B (contoh: 08123456789)
        </p>
    </div>

    <form action="{{ route('participants.import.store', $event) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-6">
            <label for="file" class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Excel</label>
            <div class="flex items-center justify-center w-full">
                <label for="file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm text-gray-700"><span class="font-semibold">Klik untuk upload</span> atau drag file ke sini</p>
                        <p class="text-xs text-gray-500">XLSX, XLS, CSV (maksimal 5MB)</p>
                    </div>
                    <input id="file" type="file" name="file" class="hidden" accept=".xlsx,.xls,.csv" required>
                </label>
            </div>
            @error('file')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div id="fileName" class="mb-6 text-sm text-gray-600"></div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">Import File</button>
            <a href="{{ route('events.show', $event) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>

<script>
    const fileInput = document.getElementById('file');
    const fileNameDiv = document.getElementById('fileName');

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            fileNameDiv.textContent = 'File yang dipilih: ' + e.target.files[0].name;
        }
    });

    // Drag and drop
    const label = document.querySelector('label[for="file"]');
    label.addEventListener('dragover', (e) => {
        e.preventDefault();
        label.classList.add('bg-blue-50', 'border-blue-300');
    });

    label.addEventListener('dragleave', () => {
        label.classList.remove('bg-blue-50', 'border-blue-300');
    });

    label.addEventListener('drop', (e) => {
        e.preventDefault();
        label.classList.remove('bg-blue-50', 'border-blue-300');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileNameDiv.textContent = 'File yang dipilih: ' + e.dataTransfer.files[0].name;
        }
    });
</script>
@endsection
