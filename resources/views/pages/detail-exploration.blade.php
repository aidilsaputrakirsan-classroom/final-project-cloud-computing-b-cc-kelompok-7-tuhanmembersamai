@extends('layouts.main')

@section('section')
    <div class="detail-exploration">
        <a href="{{ route('eksplorasi.index') }}"><img src="{{ asset('images/back.png') }}" alt="back" width="47px"
                class="back"></a>
        <div class="row d-flex">
            <div class="content-left col-lg-6">
                <div class="author-info d-flex justify-content-between">
                    <div class="name">
                        @if ($data->user->image)
                            <img width="40px" height="40px" style="border-radius: 50%; object-fit: cover;"
                                src="{{ asset('storage/user/' . $data->user->image) }}" alt="author">
                        @else
                            <img width="40px" style="border-radius: 50%" src="{{ asset('images/default-profile.png') }}">
                        @endif
                        <h4>{{ $data->user->name }}</h4>
                    </div>
                    <!-- <a href="#">kunjungi profil</a> -->
                </div>
                <div class="artwork mt-1">
                    <img src="{{ $data->image }}" alt="Illustration" class="img-fluid">
                </div>
            </div>
            <div class="content-right col-lg-6">
                <div class="description">
                    <p>{{ $data->description }}</p>
                </div>
                <div class="like-comment">
                    <div class="like">
                        <p id="likeCount">{{ $likes }}</p>
                        @if ($isLiked)
                            <img src="{{ asset('images/heart-filled.png') }}" alt="unlike" id="unlikeButton"
                                style="cursor: pointer">
                            <img src="{{ asset('images/heart.png') }}" alt="like" id="likeButton"
                                style="display: none; cursor: pointer">
                        @else
                            <img src="{{ asset('images/heart.png') }}" alt="like" id="likeButton"
                                style="cursor: pointer">
                            <img src="{{ asset('images/heart-filled.png') }}" alt="unlike" id="unlikeButton"
                                style="display: none; cursor: pointer">
                        @endif
                    </div>
                    <div class="comment">
                        <p>{{ $comment_count }}</p>
                        <button id="commentButton"><img src="{{ asset('images/comment.png') }}" alt="comment"></button>

                    </div>
                </div>
                <div class="textarea-container">
                    <div class="textarea textarea-hidden">
                        <form action="{{ route('eksplorasi.comment', $data->id) }}" method="POST">
                            @csrf
                            <textarea id="commentTextarea" rows="4" cols="30" placeholder="Pop up textarea" name="message"></textarea>
                            <button type="submit" class="btn-okay">ok</button>
                        </form>
                    </div>
                </div>
                @foreach ($comments as $comment)
                    <div class="list-comment">
                        <div class="d-flex flex-row align-items-center gap-1">
                            @if ($comment->user->image)
                                <img width="34px" height="34px" style="border-radius: 50%; object-fit: cover;"
                                    src="{{ asset('storage/user/' . $comment->user->image) }}" alt="author">
                            @else
                                <img width="34px" style="border-radius: 50%"
                                    src="{{ asset('images/default-profile.png') }}">
                            @endif
                            <h6 class="mt-1">{{ $comment->user->name }}</h6>
                        </div>
                        <p>{{ $comment->message }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const id = "{{ $data->id }}";

            // Like / Unlike handlers
            $('#likeButton').click(function() {
                $.ajax({
                    url: `/eksplorasi/like/${id}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#likeCount').text(response.count);
                        $('#likeButton').hide();
                        $('#unlikeButton').show();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });

            $('#unlikeButton').click(function() {
                $.ajax({
                    url: `/eksplorasi/like/${id}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#likeCount').text(response.count);
                        $('#unlikeButton').hide();
                        $('#likeButton').show();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Adjust artwork image: if the natural width is smaller than the container,
            // upscale it to fill the container's width (respecting max-width from CSS).
            function adjustArtworkImage() {
                const $img = $('.detail-exploration .artwork img');
                const $container = $('.detail-exploration .content-left .artwork');
                if (!$img.length || !$container.length) return;

                const imgEl = $img[0];

                function doAdjust() {
                    const naturalW = imgEl.naturalWidth || 0;
                    const containerW = $container.innerWidth();

                    // If image natural width is smaller than container, allow upscaling.
                    if (naturalW > 0 && naturalW < containerW) {
                        // Remove any max-width constraint and scale to container
                        $img.css({
                            'max-width': 'none',
                            'width': '100%',
                            'height': 'auto'
                        });
                    } else {
                        // Use responsive behavior but don't upscale beyond natural size
                        $img.css({
                            'max-width': '100%',
                            'width': '100%',
                            'height': 'auto'
                        });
                    }
                }

                if (imgEl.complete) {
                    doAdjust();
                } else {
                    $img.on('load', doAdjust);
                }
            }

            adjustArtworkImage();
            $(window).on('resize', function() {
                adjustArtworkImage();
            });
        });
    </script>
@endsection
