@extends('layouts.dashboard')

@section('content')

@if ($current_accomodation->user_id == $user_id) 
    <h1>Modifica appartamento</h1>

    {{-- Schermata che visualizza gli errori (se dovessero essercene) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.accomodations.update', ['accomodation' => $current_accomodation->id]) }}" method="post"
        enctype="multipart/form-data">
        @method('put')
        @csrf

        {{-- Input Name --}}
        <div class="form-group">
            <label for="name">Nome appartamento *</label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ old('name') ? old('name') : $current_accomodation->name }}">
        </div>

        {{-- Input descrizione --}}
        <div class="form-group">
            <label for="description">Descrizione *</label>
            <textarea type="text" class="form-control" name="description" id="description"> {{ old('description') ? old('description') : $current_accomodation->description }} </textarea>
        </div>

        {{-- Input n_rooms --}}
        <div class="form-group">
            <label for="n_rooms">Numero di stanze *</label>
            <input name="n_rooms" type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms"
                placeholder="Inserisci numero stanze"
                value="{{ old('n_rooms') ? old('n_rooms') : $current_accomodation->n_rooms }}">
        </div>

        {{-- Input n_beds --}}
        <div class="form-group">
            <label for="n_beds">Numero di letti *</label>
            <input name="n_beds" type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds"
                placeholder="Inserisci numero letti"
                value="{{ old('n_beds') ? old('n_beds') : $current_accomodation->n_beds }}">
        </div>

        {{-- Input n_bathrooms --}}
        <div class="form-group">
            <label for="n_bathrooms">Numero di bagni *</label>
            <input name="n_bathrooms" type="number" class="form-control @error('n_bathrooms') is-invalid @enderror"
                id="n_bathrooms" placeholder="Inserisci numero bagni"
                value="{{ old('n_bathrooms') ? old('n_bathrooms') : $current_accomodation->n_bathrooms }}">
        </div>

        {{-- Input square metre --}}
        <div class="form-group">
            <label for="size_sqm">Numero metri quadri *</label>
            <input name="size_sqm" type="number" class="form-control @error('size_sqm') is-invalid @enderror"
                id="size_sqm" placeholder="Inserisci numero letti"
                value="{{ old('size_sqm') ? old('size_sqm') : $current_accomodation->size_sqm }}">
        </div>

        {{-- Input Servizi --}}
        <div class="form-group">
            <h5 class="my-4">Modifica lista servizi: *</h5>
            @foreach ($facilities as $facility)
                <div class="form-check">
                    <input name="facilities[]" class="form-check-input" type="checkbox" value="{{ $facility->id }}"
                        id="facility-{{ $facility->id }}" {{-- Per ogni servizio controlliamo che questo sia incluso nei servizi collegati all appartamento.
                        Se sì si spunta il checked, altrimenti non si fa nulla. --}}
                        {{-- {{ $current_accomodation->facilities->contains($facility) || in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}> --}}
                        @if ($errors->any())
                            {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}>
                        @else
                            {{ $current_accomodation->facilities->contains($facility) || in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}>
                        @endif
                    <label class="form-check-label" for="facility-{{ $facility->id }}">
                        {{ $facility->name }}
                    </label>
                </div>
            @endforeach
        </div>

        {{-- Input Address --}}
        <div class="form-group">
            <label for="address">Modifica indirizzo *</label>
            <input type="text" class="form-control" name="address" id="address"
                value="{{ old('address') ? old('address') : $current_accomodation->address }}">
        </div>

        {{-- Input immagine --}}
        <div class="mb-3">
            <label for="image">Modifica l'immagine</label>
            <input type="file" id="image" name="image">

            @if ($current_accomodation->image)
                <h5 class="my-4">Immagine corrente</h5>
                <img style="max-width: 60%" src="{{ asset('storage/' . $current_accomodation->image) }}"
                    alt="{{ $current_accomodation->name }}">
            @endif
        </div>

        <h5 class="my-4">Visibile</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="true"
                {{ $current_accomodation->is_visible == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="visibility">
                Si
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="false"
                {{ $current_accomodation->is_visible == 0 ? 'checked' : '' }}>
            <label class="form-check-label" for="visibility">
                No
            </label>
        </div>

        {{-- Submit button --}}
        <button type="submit" class="btn btn-primary mt-3">Invia</button>
    </form>

    <p class="text-right">Legenda: * (campi obbligatori)
@else
    <p class="text-center">Non puoi accedere a questi appartamenti</p> 
@endif
@endsection
