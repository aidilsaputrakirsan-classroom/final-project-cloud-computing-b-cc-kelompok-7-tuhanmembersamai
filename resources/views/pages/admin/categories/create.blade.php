@extends('layouts.admin')
@section('title', 'Tambah Kategori')

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST" class="form-container">
    @csrf
    <label>Nama Kategori</label>
    <input type="text" name="name" placeholder="Masukkan nama kategori" required>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
