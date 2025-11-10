@extends('layouts.admin')
@section('title', 'Kelola Post')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/admin-posts.css') }}">

<div class="card">
  <div class="card-header">
    <h1>Daftar Post</h1>
  </div>

  @if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
  @endif

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Gambar</th>
          <th>Deskripsi</th>
          <th>Kategori</th>
          <th>Owner</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
          <tr>
            <td>{{ $post->id }}</td>
            <td>
              <img src="{{ $post->image }}" alt="img-{{ $post->id }}" class="thumb">
            </td>
            <td class="desc">{{ Str::limit($post->description, 80) }}</td>
            <td>{{ $post->category->name ?? '-' }}</td>
            <td>{{ $post->user->name ?? '—' }}</td>
            <td>{{ $post->created_at?->format('d/m/Y H:i') }}</td>
            <td class="actions">
              <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary">View</a>
              <a href="{{ route('admin.posts.edit', $post) }}" class="btn">Edit</a>
              <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus post ini?')" class="inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="empty">Belum ada post.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination">
    {{ $posts->links() }}
  </div>
</div>
@endsection
