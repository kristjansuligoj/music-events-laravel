@props(['data'])

<div class="d-flex justify-content-around m-5">
    <a
        class="btn btn-dark mb-3"
        style="width:200px"
        href="/{{ $data['name'] }}s/edit/{{ $data['id'] }}"
    >Edit {{ $data['name'] }}</a>

    <form method="post" action="/{{ $data['name'] }}s/remove/{{ $data['id'] }}">
        @csrf
        @method('DELETE')

        <input
            onclick="return confirm('Are you sure?')"
            class="btn btn-danger"
            style="width:200px"
            type="submit"
            value="Remove {{ $data['name'] }}"
        >
    </form>
</div>
