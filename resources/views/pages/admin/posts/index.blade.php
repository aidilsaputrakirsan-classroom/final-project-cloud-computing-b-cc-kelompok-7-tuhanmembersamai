@extends('layouts.admin')
@section('title','Kelola Post')

@section('content')

<style>
    /* Thumbnail persegi (1x1) */
    .thumb {
        width: 70px;           
        height: 70px;          
        object-fit: cover;    
        border-radius: 8px;   
        background: #eee;
    }
</style>

<div class="card">
  <div class="card-header">
    <h2>Daftar Post</h2>
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

      @forelse($posts as $p)
        <tr>
          <td>{{ $p->id }}</td>

          {{-- TAMPILKAN GAMBAR DARI SUPABASE --}}
          <td>
            @if($p->image)
              <img src="{{ $p->image }}" class="thumb" alt="img">
            @else
              <div class="thumb" style="display:grid;place-items:center;">–</div>
            @endif
          </td>

          <td class="desc">{{ Str::limit($p->description, 80) }}</td>
          <td>{{ $p->category->name ?? '-' }}</td>
          <td>{{ $p->user->name ?? '-' }}</td>
          <td>{{ $p->created_at?->format('d/m/Y H:i') }}</td>

          <td class="gap-8">
            <a class="btn btn-sm btn-primary" href="{{ route('admin.posts.show',$p) }}">View</a>
            <a class="btn btn-sm" href="{{ route('admin.posts.edit',$p) }}">Edit</a>

            <form action="{{ route('admin.posts.destroy',$p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus post ini?')">
              @csrf 
              @method('DELETE')
              <button class="btn btn-sm btn-danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>

      @empty
        <tr><td colspan="7" class="empty">Belum ada data.</td></tr>
      @endforelse

      </tbody>
    </table>
  </div>

  <div class="pagination">
    {{ $posts->links() }}
  </div>
</div>

@endsection
