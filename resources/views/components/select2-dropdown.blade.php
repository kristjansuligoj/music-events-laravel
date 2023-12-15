@props(['data'])

<div>
    <select class="form-control w-100" id="{{ $data['name'] }}" name="{{ $data['name'] }}">
        @foreach($data['dropdown-items'] as $item)
            <option
                id="{{ $item[$data['property']] }}"
                name="{{ $data['name'] }}"
                value="{{ $item['id'] }}"
                @selected(isset($data['selectedOption']) && $data['selectedOption'] === $item->id)
            >
                {{ $item[$data['property']] }}
            </option>
        @endforeach
    </select>
    @error($data['name'])
    <span class="fw-bold text-red-500">{{ $errors->first($data['name']) }}</span>
    @enderror
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mySelect').select2();
        });
    </script>
@endpush
