@extends('layouts.admin')
@section('title', 'Detail Post')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/admin-posts.css') }}">

<div class="card">
  <div class="card-header flex-between">
    <h1>Detail Post #{{ $post->id }}</h1>
    <div class="gap-8">
      <a href="{{ route('admin.posts.edit', $post) }}" class="btn">Edit</a>
      <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus post ini?')" class="inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete Post</button>
      </form>
    </div>
  </div>

  @if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
  @endif

  <div class="post-detail">
    <div class="media">
      <img src="{{ $post->image }}" class="hero" alt="post-img">
    </div>
    <div class="meta">
      <p><strong>Owner:</strong> {{ $post->user->name ?? '—' }}</p>
      <p><strong>Kategori:</strong> {{ $post->category->name ?? '-' }}</p>
      <p><strong>Dibuat:</strong> {{ $post->created_at?->format('d/m/Y H:i') }}</p>
      <p><strong>Deskripsi:</strong><br>{{ $post->description ?? '-' }}</p>
    </div>
  </div>

  <hr>

  <h2>Komentar ({{ $post->comments->count() }})</h2>
  <div class="comments">
    @forelse($post->comments as $comment)
      <div class="comment">
        <div class="comment-head">
          <span class="author">{{ $comment->user->name ?? 'User' }}</span>
          <span class="time">{{ $comment->created_at?->diffForHumans() }}</span>
        </div>
        <div class="comment-body">{{ $comment->body }}</div>
        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm">Delete Comment</button>
        </form>
      </div>
    @empty
      <p class="empty">Belum ada komentar.</p>
    @endforelse
  </div>
</div>
@endsection
