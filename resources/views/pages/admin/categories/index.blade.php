@extends('layouts.admin')
@section('title', 'Kelola Categories')

@section('content')
<div class="card">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-4">+ Tambah Kategori</a>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category['id']) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
