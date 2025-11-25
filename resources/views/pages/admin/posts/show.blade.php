@extends('layouts.admin')
@section('title','Detail Post')

@section('content')

@if(session('success')) 
  <div class="flash success">{{ session('success') }}</div> 
@endif

<style>
    .post-wrapper {
        display: flex;
        gap: 28px;
        padding: 20px;
        align-items: flex-start;
    }

    .post-image img {
        width: 260px;
        height: 260px;
        object-fit: cover;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .post-meta h2 {
        font-size: 22px;
        margin-bottom: 6px;
        color: #222;
    }

    .post-meta p {
        margin: 4px 0;
        line-height: 1.4;
        color: #444;
    }

    .post-description {
        margin-top: 12px;
        padding: 12px 16px;
        background: #f7f7f7;
        border-radius: 12px;
        border: 1px solid #ececec;
        font-size: 15px;
        line-height: 1.5;
    }

    .meta-actions {
        margin-top: 16px;
        display: flex;
        justify-content: flex-start;
        gap: 10px;
    }

    /* KOMENTAR */
    .comment {
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #ddd;
        background: #fafafa;
        margin-bottom: 12px;
    }

    .comment-head {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    .comment-body {
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #777;
    }
</style>

<div class="card">
  <div class="post-wrapper">

    <div class="post-image">
      @if($post->image)
        <img src="{{ $post->image }}" alt="Post Image">
      @else
        <div style="width:260px;height:260px;background:#eee;border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <span style="color:#888;">Tidak ada gambar</span>
        </div>
      @endif
    </div>

    <div class="post-meta">
      <h2>Post #{{ $post->id }}</h2>
      <p><b>Owner:</b> {{ $post->user->name ?? '-' }}</p>
      <p><b>Kategori:</b> {{ $post->category->name ?? '-' }}</p>
      <p><b>Dibuat:</b> {{ $post->created_at?->format('d/m/Y H:i') }}</p>

      <div class="post-description">{{ $post->description }}</div>

      <div class="meta-actions">
        <a class="btn" href="{{ route('admin.posts.edit',$post) }}">Edit</a>

        <form action="{{ route('admin.posts.destroy',$post) }}" 
              method="POST" 
              onsubmit="return confirm('Hapus post ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>

  </div>
</div>

{{-- KOMENTAR --}}
<div class="card" style="margin-top:18px">
  <div class="card-header">
      <h3 style="margin:0;">Komentar</h3>
  </div>

  <div class="comments" style="padding: 18px">

    @forelse($post->comments as $c)
      <div class="comment">
        <div class="comment-head">
          <span>{{ $c->user->name ?? 'User' }}</span>
          <small>{{ $c->created_at?->diffForHumans() }}</small>
        </div>

        <div class="comment-body">{{ $c->message }}</div>

        <form class="inline" 
              action="{{ route('admin.comments.destroy', $c) }}" 
              method="POST" 
              onsubmit="return confirm('Hapus komentar ini?')">
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
