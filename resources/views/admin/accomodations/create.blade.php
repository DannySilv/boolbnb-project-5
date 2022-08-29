@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-4">Inserisci un nuovo appartamento</h1>

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

    <form action="{{ route('admin.accomodations.store') }}" method="post" enctype="multipart/form-data">
        @method('post')
        @csrf

        {{-- Input Name --}}
        <div class="form-group">
            <label for="name">Nome appartamento</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            {{-- @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input descrizione --}}
        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea type="text" class="form-control" name="description" id="description"> {{ old('description') }} </textarea>
            {{-- @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_rooms --}}
        <div class="form-group">
            <label for="n_rooms">Numero di stanze</label>
            <input name="n_rooms" type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms"
                placeholder="Inserisci numero stanze" value="{{ old('n_rooms') }}">
            {{-- @error('n_rooms')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_beds --}}
        <div class="form-group">
            <label for="n_beds">Numero di letti</label>
            <input name="n_beds" type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds"
                placeholder="Inserisci numero letti" value="{{ old('n_beds') }}">
            {{-- @error('n_beds')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_bathrooms --}}
        <div class="form-group">
            <label for="n_bathrooms">Numero di bagni</label>
            <input name="n_bathrooms" type="number" class="form-control @error('n_bathrooms') is-invalid @enderror"
                id="n_bathrooms" placeholder="Inserisci numero bagni" value="{{ old('n_bathrooms') }}">
            {{-- @error('n_bathrooms')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Square Metre --}}
        <div class="form-group">
            <label for="size_sqm">Numero metri quadri</label>
            <input name="size_sqm" type="number" class="form-control @error('size_sqm') is-invalid @enderror"
                id="size_sqm" placeholder="Inserisci numero metri quadri" value="{{ old('size_sqm') }}">
            {{-- @error('size_sqm')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Facilities --}}
        <div class="form-group">
            <label for="facilities">Lista servizi</label>
            @foreach ($facilities as $facility)
                <div class="form-check">
                    <input name="facilities[]" class="form-check-input" type="checkbox" value="{{ $facility->id }}"
                        id="facility-{{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}">
                    <label for="facility-{{ $facility->id }}" class="form-check-label">{{ $facility->name }}</label>
                </div>
            @endforeach
        </div>

        {{-- Input Address --}}
        <div class="form-group">
            <label for="address">Indirizzo</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
            {{-- @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input immagine --}}
        <div>
            <label for="image">Seleziona un'immagine</label>
            <input type="file" id="image" name="image">
            {{-- @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Visible --}}
        <h5 class="my-4">Visibile</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="true" checked>
            <label class="form-check-label" for="visibility">
                Si
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="false">
            <label class="form-check-label" for="visibility">
                No
            </label>
        </div>

        {{-- Submit button --}}
        <button type="submit" class="btn btn-primary mt-4">Invia</button>
    </form>
@endsection
