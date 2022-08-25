@extends('layouts.dashboard')

@section('content')
    <h1>Create a new accomodation</h1>

    {{-- Schermata che visualizza gli errori (se dovessero essercene) --}}
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form action="{{ route('admin.accomodations.store') }}" method="post" enctype="multipart/form-data">
        @method('post')
        @csrf

        {{-- Input categorie --}}
        {{-- <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id">
                <option value="">None</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
        </div> --}}

        {{-- Input Name --}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
        </div>

        {{-- Input descrizione --}}
        <div class="form-group">
            <label for="description">Description</label>
            <textarea type="text" class="form-control" name="description" id="description"> {{ old('description') }} </textarea>
        </div>

        {{-- Input n_rooms --}}
        <div class="form-group">
            <label for="description">Number of rooms</label>
            <select name="" id="">
                <option value="">1</option>
                <option value="">2</option>
                <option value="">3</option>
                <option value="">4</option>
            </select>
        </div>

        {{-- Input n_beds --}}
        <div class="form-group">
            <label for="description">Number of beds</label>
            <select name="" id="">
                <option value="">1</option>
                <option value="">2</option>
                <option value="">3</option>
                <option value="">4+</option>
            </select>
        </div>

        {{-- Input n_bathrooms --}}
        <div class="form-group">
            <label for="description">Number of bathrooms</label>
            <select name="" id="">
                <option value="">1</option>
                <option value="">2</option>
                <option value="">3</option>
                <option value="">4+</option>
            </select>
        </div>

        {{-- Input Square Metre --}}
        <div class="form-group">
            <label for="description">Square Metres</label>
            <select name="" id="">
                <option value="">0 - 30</option>
                <option value="">30 - 50</option>
                <option value="">50 - 70</option>
                <option value="">70 - 120</option>
                <option value="">120+</option>
            </select>
        </div>

        {{-- Input Address --}}
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
        </div>

        {{-- Input Tag --}}
        {{-- <div class="form-group">
            <h5 class="my-4">Select tags for your post (1 or many)</h5>
            @foreach ($tags as $tag)
                <div class="form-check">
                    <input name="tags[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}"
                        id="tag-{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="tag-{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                </div>
            @endforeach
        </div> --}}

        {{-- Input immagine --}}
        <div>
            <label for="image">Select an image </label>
            <input type="file" id="image" name="image">
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
