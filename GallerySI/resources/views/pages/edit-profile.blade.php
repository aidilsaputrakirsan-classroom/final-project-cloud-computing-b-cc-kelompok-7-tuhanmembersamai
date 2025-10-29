@extends('layouts.main')

@section('section')
@include('partials.alert')
<div class="profile-container">
    <a href="{{ url()->previous() }}"><img src="{{ asset('images/back.png') }}" alt="back" width="40px"
            class="back"></a>
    <div class="profile-info mb-5">
        @if ($profile->image)
        <img src="{{ asset('storage/user/' . $profile->image) }}" alt="profile">
        @else
        <img src="{{ asset('images/default-profile.png') }}" alt="profile">
        @endif
        <div class="detail">
        <h4>{{ auth()->user()->name }}</h4>
                <p>{{ auth()->user()->address }}</p>
            <button class="change-photo" data-bs-toggle="modal" data-bs-target="#modalUpdatePhoto">Perbarui
                Foto</button>
            <!-- Modal -->
            <div class="modal fade" id="modalUpdatePhoto" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ganti Foto Profil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('update.profile.photo') }}" method="POST"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <input type="file" class="form-control" id="customFile" name="image">
                                <button type="submit" class="btn-action mt-3">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-me d-block mt-5">
        <form action="{{ route('update.profile') }}" method="POST" class="d-flex flex-row w-100 px-5">
            @csrf
            @method('PUT')
            <div class="col-lg-6 px-2">
                <div class="mb-4">
                    <input type="text" placeholder="Nama" name="name" id="name" value="{{ $profile->name }}">
                </div>
                <div class="mb-4">
                    <textarea rows="16" type="text" placeholder="Biografi atau deskripsi diri" name="description"
                        id="bio">{{ $profile->description }}</textarea>
                </div>
                <div class="mt-1">
                    <textarea type="text" placeholder="Keahlian" name="skill"
                        id="keahlian">{{ $profile->skill }}</textarea>
                </div>
            </div>
            <div class="col-lg-3 px-2 mt-5">
                <div class="mt-3 mb-3">
                    <input type="text" placeholder="Alamat" name="address" id="address" value="{{ $profile->address }}">
                </div>
                <div class="mb-5">
                    <input type="email" placeholder="Email" name="email" id="email" value="{{ $profile->email }}">
                </div>
                <div class="mb-2">
                    <input type="text" placeholder="Instagram" name="instagram" id="instagram"
                        value="{{ $profile->instagram }}">
                </div>
                <div class="mb-2">
                    <input type="text" placeholder="Twitter" name="twitter" id="twitter"
                        value="{{ $profile->twitter }}">
                </div>
                <div class="mb-2">
                    <input type="text" placeholder="Linkedin" name="linkedin" id="linkedin"
                        value="{{ $profile->linkedin }}">
                </div>
                <div class="mb-2">
                    <input type="text" placeholder="Facebook" name="facebook" id="facebook"
                        value="{{ $profile->facebook }}">
                </div>
                <div class="mb-2">
                    <input type="text" placeholder="Website pribadi (opsional)" name="website" id="website"
                        value="{{ $profile->website }}">
                </div>
            </div>
            <div class="col-lg-3 w-25">
                <div class="action">
                    <button class="btn-action">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
