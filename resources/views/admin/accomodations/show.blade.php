@extends('layouts.dashboard')

@section('content')
    @if ($current_accomodation->user_id == $user_id)
        <div class="container" style="height: 500px">
            <div class="row">
                {{-- Colonna immagine --}}
                <div class="col-lg-8 col-xs-12">
                    @if ($current_accomodation->image)
                        <img class="acc_image w-100 rounded" style="max-height: 450px; object-fit:cover;"
                            src="{{ asset('storage/' . $current_accomodation->image) }}"
                            alt="{{ $current_accomodation->name }}">
                    @endif
                </div>
                {{-- /Colonna immagine --}}

                {{-- Colonna informazioni --}}
                <div class="col-lg-4 col-xs-12 mt-1">
                    <h3 class="mt-2 mb-3">
                        <i class="text-center"> {{ $current_accomodation->name }} </i>
                    </h3>
                    <p>{{ $current_accomodation->description }}</p>
                    <div class="d-flex mb-2">
                        <div>
                            <small><i class="fas fa-person-booth mr-2"></i>Stanze:
                                {{ $current_accomodation->n_rooms }}</small><br>
                            <small><i class="fas fa-bed mr-2"></i>Posti letto:
                                {{ $current_accomodation->n_beds }}</small><br>
                            <small><i class="fas fa-restroom mr-2"></i>Bagni:
                                {{ $current_accomodation->n_bathrooms }}</small><br>
                        </div>

                        <div class="d-sm-block" style="padding-left: 1.5rem;">

                            <span class="text-secondary">Lista Servizi</span><br>

                            {{-- <ul class="dropdown-menu">
                                <li> --}}
                            <small class="my-3">
                                @forelse ($current_accomodation->facilities as $facility)
                                    {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
                                    {{ $facility->name }}{{ $loop->last ? '' : ', ' }}
                                    <br>
                                    {{-- Stampiamo una virgola solo se non è l'ultimo elemento nel loop --}}
                                @empty
                                    None
                                @endforelse
                            </small>
                            {{-- </li>
                            </ul> --}}
                        </div>
                    </div>
                    {{-- /Colonna informazioni --}}

                    {{-- delete-destroy button --}}
                    <div class="d-flex mt-3" style="max-width: 350px; min-width: 120px">
                        <div class="btn_hov">
                            <a class="edit_btn btn mr-3"
                                href="{{ route('admin.accomodations.edit', ['accomodation' => $current_accomodation->id]) }}">
                                Modifica appartamento
                            </a>
                        </div>

                        <form class="btn_hov"
                            action="{{ route('admin.accomodations.destroy', ['accomodation' => $current_accomodation->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="delete_btn btn" onclick="return confirm('Sei sicuro fratello?')">
                                Elimina appartamento
                            </button>
                            <p class="d-none"></p>
                        </form>
                    </div>
                    {{-- / delete-destroy button --}}
                </div>
            </div>
        </div>

        <div class="arrow_container">
            @if ($current_accomodation->id > 1)
                <a class="indietro" href="{{ route('admin.accomodations.show', [$current_accomodation->id - 1]) }}">
                    <h1>
                        <i class="fas fa-chevron-left"></i>
                    </h1>
                </a>
            @endif

            @if ($current_accomodation->id < 8)
                <a class="avanti" href="{{ route('admin.accomodations.show', [$current_accomodation->id + 1]) }}">
                    <h1>
                        <i class="fas fa-chevron-right"></i>
                </a>
                </h1>
            @endif
        </div>
        {{-- @if ($current_accomodation->image)
            <img class="my-4" style="max-width: 60%" src="{{ asset('storage/' . $current_accomodation->image) }}"
                alt="{{ $current_accomodation->name }}">
        @endif --}}
    @else
        <p class="text-center">Non puoi accedere a questo appartamento</p>
    @endif
@endsection
