@extends('layouts.dashboard')

@section('content')
    <h1>Create a new accomodation</h1>

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
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            {{-- @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input descrizione --}}
        <div class="form-group">
            <label for="description">Description</label>
            <textarea type="text" class="form-control" name="description" id="description"> {{ old('description') }} </textarea>
            {{-- @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_rooms --}}
        <div class="form-group">
            <label for="n_rooms">Rooms Number</label>
            <input name="n_rooms" type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms"
                placeholder="Enter rooms number" value="{{ old('n_rooms') }}">
            {{-- @error('n_rooms')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_beds --}}
        <div class="form-group">
            <label for="n_beds">Beds Number</label>
            <input name="n_beds" type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds"
                placeholder="Enter beds number" value="{{ old('n_beds') }}">
            {{-- @error('n_beds')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input n_bathrooms --}}
        <div class="form-group">
            <label for="n_bathrooms">Bathrooms Number</label>
            <input name="n_bathrooms" type="number" class="form-control @error('n_bathrooms') is-invalid @enderror"
                id="n_bathrooms" placeholder="Enter bathrooms number" value="{{ old('n_bathrooms') }}">
            {{-- @error('n_bathrooms')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Facilities --}}
        <div class="form-group">
            <label for="n_bathrooms">Facilities list</label>
            @foreach ($facilities as $facility)
                <div class="form-check">
                    <input name="facilities[]" class="form-check-input" type="checkbox" value="{{ $facility->id }}"
                        id="facility-{{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}">
                    <label for="facility-{{ $facility->id }}" class="form-check-label">{{ $facility->name }}</label>
                </div>
            @endforeach
        </div>

        {{-- Input Square Metre --}}
        <div class="form-group">
            <label for="size_sqm">Square metres Number</label>
            <input name="size_sqm" type="number" class="form-control @error('size_sqm') is-invalid @enderror"
                id="size_sqm" placeholder="Enter square metres" value="{{ old('size_sqm') }}">
            {{-- @error('size_sqm')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Address --}}
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
            {{-- @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input immagine --}}
        <div>
            <label for="image">Select an image </label>
            <input type="file" id="image" name="image">
            {{-- @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror --}}
        </div>

        {{-- Input Visible --}}
        <h5 class="my-4">Visible</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Yes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                No
            </label>
        </div>

        {{-- Submit button --}}
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
@endsection
