@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
<form action="{{ route('admin.categories.update', $category['id']) }}" method="POST" class="form-container">
    @csrf
    @method('PUT')
    <label>Nama Kategori</label>
    <input type="text" name="name" value="{{ $category['name'] }}" required>

    <button type="submit" class="btn btn-success">Perbarui</button>
</form>
@endsection
