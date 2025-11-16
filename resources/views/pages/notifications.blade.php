@extends('layouts.main')

@section('section')
<div class="container mt-5">
    <h2>Notifikasi</h2>

    <hr>

    <h4>Like</h4>
    @forelse ($likeNotif as $notif)
        <div class="alert alert-info">
            <strong>{{ $notif->user->name }}</strong> menyukai karya kamu:
            <em>{{ $notif->artwork->description }}</em>
            <br><small>{{ $notif->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>Belum ada yang like karya kamu</p>
    @endforelse

    <hr>

    <h4>Komentar</h4>
    @forelse ($commentNotif as $notif)
        <div class="alert alert-warning">
            <strong>{{ $notif->user->name }}</strong> mengomentari karya kamu:
            <em>{{ $notif->message }}</em>
            <br><small>{{ $notif->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>Belum ada komentar di karya kamu</p>
    @endforelse
</div>
@endsection
