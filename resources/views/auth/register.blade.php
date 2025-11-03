@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar Akun Baru</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-semibold">Daftar</button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
    </div>
</div>
@endsection
