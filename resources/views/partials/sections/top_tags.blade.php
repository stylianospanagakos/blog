@component('components.card.card', ['my' => 2, 'classes' => 'd-block'])

    @component('components.card.header')
        <h5 class="text-gray-500 m-0"><i class="fa fa-award"></i> Top {{ $top_count }} Tags</h5>
    @endcomponent

    @component('components.card.body')
        @foreach($popular as $tag)
            <div>
                <a href="{{ route('tags.show', $tag->name) }}">{{ $tag->name }}</a>
            </div>
        @endforeach
    @endcomponent

@endcomponent