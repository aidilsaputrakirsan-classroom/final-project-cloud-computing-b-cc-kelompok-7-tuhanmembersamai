@extends('layouts.admin')
@section('title', 'Edit Post')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/admin-posts.css') }}">

<div class="card">
  <div class="card-header"><h1>Edit Post #{{ $post->id }}</h1></div>

  @if ($errors->any())
    <div class="flash danger">
      <ul>
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="form">
    @csrf @method('PUT')

    <label class="label">Kategori</label>
    <select name="category_id" class="input">
      <option value="">— Pilih —</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" @selected($post->category_id == $cat->id)>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>

    <label class="label">URL Gambar</label>
    <input type="text" name="image" class="input" value="{{ old('image', $post->image) }}" required>

    <label class="label">Deskripsi</label>
    <textarea name="description" rows="6" class="input">{{ old('description', $post->description) }}</textarea>

    <div class="form-actions">
      <a href="{{ route('admin.posts.show', $post) }}" class="btn">Batal</a>
      <button class="btn btn-primary">Simpan Perubahan</button>
    </div>
  </form>
</div>
@endsection
