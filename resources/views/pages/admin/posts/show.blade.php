@extends('layouts.admin')
@section('title','Detail Post')

@section('content')
@if(session('success')) <div class="flash success">{{ session('success') }}</div> @endif

<div class="card">
  <div class="post-detail">
    <div>
      @if($post->image)
        <img class="hero" src="{{ asset('storage/'.$post->image) }}" alt="">
      @endif
    </div>
    <div class="meta">
      <h2>#{{ $post->id }}</h2>
      <p><b>Owner:</b> {{ $post->user->name ?? '-' }}</p>
      <p><b>Kategori:</b> {{ $post->category->name ?? '-' }}</p>
      <p><b>Dibuat:</b> {{ $post->created_at?->format('d/m/Y H:i') }}</p>
      <p style="margin-top:8px">{{ $post->description }}</p>

      <div class="flex-between" style="margin-top:12px">
        <a class="btn" href="{{ route('admin.posts.edit',$post) }}">Edit</a>
        <form action="{{ route('admin.posts.destroy',$post) }}" method="POST" onsubmit="return confirm('Hapus post ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card" style="margin-top:14px">
  <div class="card-header"><h3>Komentar</h3></div>

  <div class="comments">
    @forelse($post->comments as $c)
      <div class="comment">
        <div class="comment-head">
          <span>{{ $c->user->name ?? 'User' }}</span>
          <small>{{ $c->created_at?->diffForHumans() }}</small>
        </div>
        <div class="comment-body">{{ $c->body }}</div>
        <form class="inline" action="{{ route('admin.comments.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    @empty
      <div class="empty">Belum ada komentar.</div>
    @endforelse
  </div>
</div>
@endsection
