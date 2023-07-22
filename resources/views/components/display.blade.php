<a href="/">Back</a><br>
@props(['component', 'data'])

<div>
    <h3>{{ $component }}s page</h3>
    <article>
        @component($component.'s.'.$component, [$component => $data]) @endcomponent
    </article>
</div>
