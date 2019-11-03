@extends('layouts.app')

@section('content')

    @if (Auth::user())
        <div class="mb-3 text-right">
            @include('partials.buttons.action', [
                'href' => route('posts.create'),
                'theme' => 'primary',
                'icon' => 'plus',
                'big' => true,
                'text' => 'New Post'
            ])
        </div>
    @endif

    @if (count($posts))

        <div class="row">

            <div class="col-8">

                @foreach($posts->chunk(2) as $chunk)

                    <div class="row">

                        @foreach($chunk as $post)

                            <div class="col-md-6">

                                @component('components.card.card', ['my' => 2])
                                    @component('components.card.header')
                                        <div class="row">
                                            <div class="col">
                                                <h4>{{ $post->title }}</h4>
                                            </div>
                                            @if (Auth::user() && Auth::user()->id === $post->user_id)
                                                <div class="dropdown px-3">
                                                    <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="{{ url('/posts/' . $post->id . '/edit') }}">
                                                            <i class="fa fa-pen text-gray-500 mr-2"></i> Edit Post
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('posts.destroy', $post->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                                                            <i class="fa fa-trash text-gray-500 mr-2"></i> Delete Post
                                                        </a>

                                                        <form id="delete-form" action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-gray-500 m-0 small-text">by {{ $post->user->name }}</p>
                                        <div>
                                            @foreach($post->tags as $tag)
                                                <span class="badge badge-info text-white">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    @endcomponent

                                    @component('components.card.body')
                                        <p class="m-0">{{ Str::limit($post->body, 80) }}</p>
                                        <div class="text-gray-500 my-2">
                                            <span>
                                                <i class="fa fa-comment info-text"></i> {{ $post->comments->count() }}
                                            </span>
                                            <span class="ml-2">
                                                <i class="fa fa-heart danger-text"></i> {{ $post->likes->count() }}
                                            </span>
                                        </div>
                                    @endcomponent
                                    @component('components.card.footer')
                                        @include('partials.buttons.action', [
                                            'href' => url('/posts/' . $post->id),
                                            'theme' => 'primary',
                                            'icon' => 'eye',
                                            'big' => true,
                                            'classes' => 'd-block',
                                            'text' => 'View Post'
                                        ])
                                    @endcomponent
                                @endcomponent

                            </div>

                        @endforeach

                    </div>

                @endforeach

            </div>

            <div class="col-4">

                @include('partials.sections.top_tags')

            </div>

        </div>

        <div class="mt-4 text-center">
            {{ $posts->links('partials.pagination.links') }}
        </div>

    @endif

@endsection
