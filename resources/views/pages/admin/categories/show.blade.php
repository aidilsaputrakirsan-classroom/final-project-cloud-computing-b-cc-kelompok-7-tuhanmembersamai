@extends('layouts.admin')
@section('title', 'Kelola Categories')
@section('content')
<style>
  .card { background:#fff;padding:20px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06); max-width:720px; margin:auto; }
  .meta { color:#666; margin-top:6px; }
  .btn { padding:8px 12px; border-radius:8px; text-decoration:none; display:inline-block; }
  .btn-edit { background:#17a2b8;color:#fff; }
  .btn-back { background:#6c757d;color:#fff; }
  .btn-delete { background:#dc3545;color:#fff; border:none; cursor:pointer; }
</style>

<div class="card">
  <h2>Detail Kategori</h2>

  @if(session('success'))
    <div style="background:#e6ffed;color:#055a2b;padding:10px;border-radius:8px;margin-bottom:12px;">
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div style="background:#ffe6e6;color:#8a1f1f;padding:10px;border-radius:8px;margin-bottom:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  @if(isset($category))
    <p><strong>ID:</strong> {{ $category['id'] }}</p>
    <p><strong>Nama:</strong> {{ $category['name'] }}</p>
    <p class="meta"><strong>Created at:</strong> {{ isset($category['created_at']) ? \Carbon\Carbon::parse($category['created_at'])->toDayDateTimeString() : '-' }}</p>
    <p class="meta"><strong>Updated at:</strong> {{ isset($category['updated_at']) ? \Carbon\Carbon::parse($category['updated_at'])->toDayDateTimeString() : '-' }}</p>

    <div style="margin-top:16px;">
      <a href="{{ route('categories.edit', $category['id']) }}" class="btn btn-edit">Edit</a>

      <form action="{{ route('categories.destroy', $category['id']) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus kategori ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-delete">Hapus</button>
      </form>

      <a href="{{ route('categories.index') }}" class="btn btn-back">Kembali ke daftar</a>
    </div>
  @else
    <p>Data kategori tidak ditemukan.</p>
    <a href="{{ route('categories.index') }}" class="btn btn-back">Kembali ke daftar</a>
  @endif
</div>
@endsection
