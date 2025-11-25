@extends('layouts.admin')
@section('title','Edit Post')

@section('content')
<div class="card">
  <div class="card-header"><h2>Edit Post #{{ $post->id }}</h2></div>

  <form class="form" action="{{ route('admin.posts.update',$post) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <label class="label">Kategori</label>
    <select name="category_id" required>
      <option value="">-- pilih --</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected':'' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>

    <label class="label">Deskripsi</label>
    <textarea name="description" rows="4">{{ old('description',$post->description) }}</textarea>

    <label class="label">Gambar (opsional)</label>
    <input type="file" name="image" class="input" accept="image/*">
    @if($post->image)
      <small>File saat ini: {{ $post->image }}</small>
    @endif

    <div class="form-actions">
      <a class="btn" href="{{ route('admin.posts.show',$post) }}">Batal</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </form>
</div>
@endsection
