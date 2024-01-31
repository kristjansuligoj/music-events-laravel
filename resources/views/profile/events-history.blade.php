<x-app-layout>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('I have attended these events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @foreach($events as $event)
                    <article class="p-3 border mt-5 bg-gray-100 shadow sm:rounded-lg w-full">
                        <div class="d-flex align-items-center">
                            <div>
                                <b>Name:</b> {{ $event->name }}<br>
                                <b>Date:</b> {{ $event->date }}<br>
                                <b>Musician:</b> {{ $event->musicians[0]->name }} <br>
                            </div>
                            <div class="ml-auto text-center"> <!-- Use ml-auto instead of ms-auto -->
                                <x-button :href="'/events/' . $event->id" :buttonText="'More details'"/>
                            </div>
                        </div>
                    </article>

                @endforeach
                <div class="d-flex justify-content-center m-5">
                    @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{$events->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
