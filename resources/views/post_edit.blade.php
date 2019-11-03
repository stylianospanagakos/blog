@extends('layouts.app')

@section('content')

    @component('components.card.card', ['classes' => 'd-block'])

        @component('components.card.header')
            <h4>Edit Post</h4>
            <p class="text-gray-500 m-0 small-text">last update on {{ $post->updated_at }}</p>
        @endcomponent

        @component('components.card.body')

            <form method="POST" action="{{ route('posts.update', $post->id) }}">
                @csrf

                @method('PUT')

                @include('partials.form.input_text', [
                    'label' => 'Title:',
                    'name' => 'title',
                    'placeholder' => 'Enter title',
                    'value' => $post->title
                ])

                @include('partials.form.textarea', [
                    'label' => 'Content:',
                    'name' => 'body',
                    'placeholder' => 'Enter post content',
                    'value' => $post->body
                ])

                @include('partials.form.input_text', [
                    'label' => 'Tags:',
                    'name' => 'tags',
                    'placeholder' => 'Enter tags',
                    'value' => implode(',', $post->tags->pluck('name')->toArray()),
                    'subtitle' => 'Separate tags by using the comma (,) symbol'
                ])

                @include('partials.buttons.submit', [
                    'theme' => 'primary',
                    'big' => true,
                    'icon' => 'save',
                    'text' => 'Update Post'
                ])
            </form>

        @endcomponent

    @endcomponent

@endsection
