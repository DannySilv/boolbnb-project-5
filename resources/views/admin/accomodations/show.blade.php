@extends('layouts.dashboard')

@section('content')
    @if ($current_accomodation->user_id == $user_id) 
        <h1 class="my-1"> {{ $current_accomodation->name }} </h1>
        @if ($current_accomodation->image)
            <img class="my-4" style="max-width: 60%" src="{{ asset('storage/' . $current_accomodation->image) }}"
                alt="{{ $current_accomodation->name }}">
        @endif
        <p>Numero di stanze: {{ $current_accomodation->n_rooms }}</p>
        <p>Posti letto: {{ $current_accomodation->n_beds }}</p>
        <p>Numero di bagni: {{ $current_accomodation->n_bathrooms }}</p>
        <p class="my-3">
            Lista servizi: <br><br>
            @forelse ($current_accomodation->facilities as $facility)
                {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
                {{ $facility->name }}{{ $loop->last ? '' : ', ' }}
                <br>
                {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
            @empty
                None
            @endforelse
        </p>
        <p class="my-4" style="width: 50%">{{ $current_accomodation->description }}</p>

        <div class="d-flex justify-content-between" style="max-width: 350px; min-width: 120px">
            <a class="btn btn-primary"
                href="{{ route('admin.accomodations.edit', ['accomodation' => $current_accomodation->id]) }}">
                Modifica
                appartamento
            </a>
            <form action="{{ route('admin.accomodations.destroy', ['accomodation' => $current_accomodation->id]) }}"
                method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro fratello?')">Elimina
                    appartamento</button>
            </form>
        </div>
    @else
        <p class="text-center">Non puoi accedere a questi appartamenti</p> 
    @endif
@endsection
