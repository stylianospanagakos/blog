@extends('layouts.app')

@section('content')

    @component('components.card.card', ['classes' => 'd-block'])

        @component('components.card.header')
            <h4>New Post</h4>
        @endcomponent

        @component('components.card.body')

            <form method="POST" action="{{ route('posts.store') }}">
                @csrf

                @include('partials.form.input_text', [
                    'label' => 'Title:',
                    'name' => 'title',
                    'placeholder' => 'Enter title',
                    'value' => ''
                ])

                @include('partials.form.textarea', [
                    'label' => 'Content:',
                    'name' => 'body',
                    'placeholder' => 'Enter post content',
                    'value' => '',
                ])

                @include('partials.form.input_text', [
                    'label' => 'Tags:',
                    'name' => 'tags',
                    'placeholder' => 'Enter tags',
                    'value' => '',
                    'subtitle' => 'Separate tags by using the comma (,) symbol'
                ])

                @include('partials.buttons.submit', [
                    'theme' => 'primary',
                    'big' => true,
                    'icon' => 'save',
                    'text' => 'Publish Comment'
                ])
            </form>

        @endcomponent

    @endcomponent

@endsection
