@extends('layout.main')

@section('content')

<form action="{{ route('perusahaan.store') }}" method="POST">
    @csrf
    <label for="perusahaan_id">Pilih Perusahaan yang Sudah Ada:</label>
    <select name="perusahaan_id" id="perusahaan_id" required>
        @foreach($perusahaans as $perusahaan)
            <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
        @endforeach
    </select>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Konfirmasi Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit">Buat Akun</button>
</form>


@endsection
