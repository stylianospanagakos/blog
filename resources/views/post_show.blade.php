@extends('layouts.app')

@section('content')

    @component('components.card.card', ['classes' => 'd-block'])

        @component('components.card.header')
            <div class="row">
                <div class="col">
                    <h4>{{ $post->title }}</h4>
                </div>
                <div class="mr-3 likes-container">
                    @if (Auth::user())
                        <a data-count="{{ $post->likes_count }}" class="love-button shadow rounded-circle {{ $liked ? 'liked'  : '' }}"><i class="fa fa-heart"></i></a>
                    @else
                        <div class="love-placeholder d-inline-block">
                            <i class="fa fa-heart danger-text"></i>
                        </div>
                    @endif
                    <span class="text-gray-500 ml-2 likes-count">{{ $post->likes_count }} like{{ $post->likes_count === 1 ? '' : 's' }}</span>
                </div>
            </div>
            <p class="text-gray-500 m-0 small-text">by {{ $post->user->name }}</p>
        @endcomponent

        @component('components.card.body')
            <p class="m-0">{{ $post->body }}</p>

            <div>
                @foreach($post->tags as $tag)
                    <span class="badge badge-info text-white small-text">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endcomponent

        <hr>

        <div class="px-4 py-2">

            <h5>{{ $post->comments_count }} comment{{ $post->comments_count === 1 ? '' : 's' }}</h5>

            <ul>
                @if ($post->comments_count)

                    @foreach ($post->comments as $comment)
                        <li>
                            <p class="m-0">{{ $comment->comment }}</p>
                            <p class="m-0 text-gray-500 small-text">{{ $comment->user->name }} on {{ $comment->created_at }}</p>
                        </li>
                    @endforeach

                @endif
            </ul>

            <div class="my-4">
                @if (Auth::user())
                    <form method="POST" action="{{ route('comments.store', $post->id) }}">
                        @csrf

                        <div class="form-group">
                            <textarea name="comment" class="form-control form-control-user font-size-1 rounded{{ $errors->has('comment') ? ' is-invalid' : '' }}" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter your comment" >{{ old('comment') }}</textarea>
                            @if ($errors->has('comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>
                        @include('partials.buttons.submit', [
                            'theme' => 'primary',
                            'big' => true,
                            'icon' => 'save',
                            'text' => 'Publish Comment'
                        ])
                    </form>
                @else
                    @component('components.alerts.tip')
                        You need to <a href="{{ route('login') }}" class="text-white underlined">login</a> or <a href="{{ route('register') }}" class="text-white underlined">register</a> to be able to leave comments.
                    @endcomponent
                @endif
            </div>

        </div>

    @endcomponent

@endsection

@push('scripts')

    <script type="text/javascript">

        $(document).on('click', '.love-button', function () {

            // check if it's clicked
            var $this = $(this),
                is_liked = $this.hasClass('liked'),
                count = parseInt($this.attr('data-count')),
                new_count = is_liked ? count - 1 : count + 1;

            // update class
            if (is_liked) {
                $this.removeClass('liked');
            } else {
                $this.addClass('liked');
            }

            // update count
            $this.attr('data-count', new_count);
            $('.likes-count').html(new_count + ' like' + (new_count === 1 ? '' : 's'));

            $.ajax({
                type: 'POST',
                url: '{{ route('likes.store', $post->id) }}',
                data: {
                    is_liked: is_liked ? 1 : 0
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                }
            });
        });

    </script>

@endpush
