<a href="/">Back</a><br>
@props(['component', 'data'])

<h3>{{ $component }}s page</h3>

<body>
<article>
    @component($component.'s.'.$component, [$component => $data]) @endcomponent
</article>
</body>
