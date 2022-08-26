@extends('layouts.dashboard')

@section('content')
    <h1 class="my-1"> {{ $current_accomodation->name }} </h1>
    @if ($current_accomodation->image)
        <img class="my-4" src="{{ asset('storage/' . $current_accomodation->image) }}"
            alt="{{ $current_accomodation->name }}">
    @endif
    <p class="my-3">
        Facilities ->
        @forelse ($current_accomodation->facilities as $facility)
            {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
            {{ $facility->name }}{{ $loop->last ? '' : ', ' }}
            {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
        @empty
            None
        @endforelse
    </p>
    <p class="my-3" style="width: 50%">{{ $current_accomodation->description }}</p>

    <div class="d-flex justify-content-between" style="max-width: 150px; min-width: 120px">
        {{-- <a class="btn btn-primary" href="{{ route('admin.posts.edit', ['post' => $current_accomodation->id]) }}">Update
        </a> --}}
        {{-- <form action="{{ route('admin.accomodations.destroy', ['accomodation' => $current_accomodation->id]) }}"
            method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro fratello?')">Delete</button>
        </form> --}}
    </div>
@endsection
