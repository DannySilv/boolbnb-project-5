@extends('layouts.dashboard')

@section('content')
    <div class="ml-2 mr-2">
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

        <form action="{{ route('admin.accomodations.store') }}" method="post" enctype="multipart/form-data" id="appForm">
            @method('post')
            @csrf

            {{-- Input Name --}}
            <div class="form-group">
                <label for="name">Nome appartamento *</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>

            {{-- Input descrizione --}}
            <div class="form-group">
                <label for="description">Descrizione *</label>
                <textarea type="text" class="form-control" name="description" id="description"> {{ old('description') }} </textarea>
            </div>

            {{-- Input n_rooms --}}
            <div class="form-group">
                <label for="n_rooms">Numero di stanze *</label>
                <input name="n_rooms" type="number" class="form-control" id="n_rooms" placeholder="Inserisci numero stanze"
                    value="{{ old('n_rooms') }}">
            </div>

            {{-- Input n_beds --}}
            <div class="form-group">
                <label for="n_beds">Numero di letti *</label>
                <input name="n_beds" type="number" class="form-control" id="n_beds" placeholder="Inserisci numero letti"
                    value="{{ old('n_beds') }}">
            </div>

            {{-- Input n_bathrooms --}}
            <div class="form-group">
                <label for="n_bathrooms">Numero di bagni *</label>
                <input name="n_bathrooms" type="number" class="form-control" id="n_bathrooms"
                    placeholder="Inserisci numero bagni" value="{{ old('n_bathrooms') }}">
            </div>

            {{-- Input Square Metre --}}
            <div class="form-group">
                <label for="size_sqm">Numero metri quadri *</label>
                <input name="size_sqm" type="number" class="form-control" id="size_sqm"
                    placeholder="Inserisci numero metri quadri" value="{{ old('size_sqm') }}">
            </div>

            {{-- Input Facilities --}}
            <div class="form-group">
                <label for="facilities">Lista servizi *</label>
                @foreach ($facilities as $facility)
                    <div class="form-check">
                        <input name="facilities[]" class="form-check-input one_required" type="checkbox"
                            value="{{ $facility->id }}" id="facility-{{ $facility->id }}"
                            {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}>
                        <label for="facility-{{ $facility->id }}" class="form-check-label">{{ $facility->name }}</label>
                    </div>
                @endforeach
                <span id="errorToShow"></span>
            </div>

            {{-- Input Address --}}
            <div class="form-group">
                <label>Indirizzo *</label>
                <input type="text" class="form-control" name="address" id="address" onkeyup="searchAddress()"
                    value="{{ old('address') }}">
                <div id="suggestions-container" class="mt-2"></div>
                <input type="text" class="form-control d-none" name="latitude" id="latitude" value="{{ old('latitude') }}">

                <input type="text" class="form-control d-none" name="longitude" id="longitude"
                    value="{{ old('longitude') }}">

            </div>

            {{-- Input immagine --}}
            <div>
                <label for="image">Seleziona un'immagine</label>
                <input class="img_required" type="file" id="image" name="image">
                <div id="imgErrorToShow"></div>
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
            <button type="submit" id="submit" class="btn btn-primary mt-4 ms_btn_disabled" disabled>Invia</button>
        </form>

        <p class="text-right">Legenda: * (campi obbligatori)
        </p>

    </div>

    <script>
        function searchAddress() {
            // window.axios.defaults.headers.common = {
            //     'Accept': 'application/json',
            //     'Content-Type': 'application/json',
            // };
            const resultsContainer = document.getElementById('suggestions-container');
            resultsContainer.innerHTML = '';
            const query = document.getElementById('address').value;
            const linkApi =
                `https://api.tomtom.com/search/2/search/${query}.json?key=tK1dfG1bbj4Bwrg4EHPfImXRSLMFlytw&language=it-IT`
            axios.get(linkApi).then(resp => {
                const response = resp.data.results;
                response.forEach(element => {
                    const divElement = document.createElement('div');
                    divElement.classList.add('active');
                    divElement.innerHTML = element.address.freeformAddress;
                    document.getElementById('suggestions-container').append(divElement);
                    divElement.addEventListener('click', function() {
                        document.getElementById('address').value = element.address.freeformAddress;
                        document.getElementById('latitude').value = element.position.latitude;
                        document.getElementById('longitude').value = element.position.longitude;
                        resultsContainer.innerHTML = '';
                    });
                });

            });
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#appForm").validate({
                errorPlacement: function(error, element) {
                    if ($(element).hasClass("one_required")) {
                        error.appendTo("#errorToShow");
                    } else if ($(element).hasClass("img_required")) {
                        error.appendTo("#imgErrorToShow");
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    description: {
                        required: true,
                        minlength: 10,
                        maxlength: 30000
                    },
                    n_rooms: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 99
                    },
                    n_beds: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 99
                    },
                    n_bathrooms: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 99
                    },
                    size_sqm: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 500
                    },
                    'facilities[]': {
                        required: true,
                    },
                    address: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    image: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "E' necessario inserire il nome.",
                        minlength: "Il nome è troppo corto.",
                        maxlength: "Il nome è troppo lungo."
                    },
                    description: {
                        required: "E' necessario inserire la descrizione.",
                        minlength: "La descrizione è troppo corta.",
                        maxlength: "La descrizione è troppo lunga."
                    },
                    n_rooms: {
                        required: "E' necessario inserire il numero di stanze.",
                        min: "Ogni appartamento deve avere almeno una stanza.",
                        max: "Ogni appartamento può avere al massimo 99 stanze.",
                    },
                    n_beds: {
                        required: "E' necessario inserire il numero di letti.",
                        min: "Ogni appartamento deve avere almeno un posto letto.",
                        max: "Ogni appartamento può avere al massimo 99 posti letto.",
                    },
                    n_bathrooms: {
                        required: "E' necessario inserire il numero di bagni.",
                        min: "Ogni appartamento deve avere almeno un bagno.",
                        max: "Ogni appartamento può avere al massimo 99 bagni.",
                    },
                    size_sqm: {
                        required: "E' necessario inserire il numero di metri quadri.",
                        min: "Ogni appartamento deve avere almeno un m².",
                        max: "Ogni appartamento può avere al massimo 500 m².",
                    },
                    'facilities[]': {
                        required: "E' necessario inserire almeno un servizio.",
                    },
                    address: {
                        required: "E' necessario inserire l'indirizzo.",
                        minlength: "L'indirizzo che hai inserito è troppo corto.",
                        maxlength: "L'indirizzo che hai inserito è troppo lungo.",
                    },
                    image: {
                        required: "E' necessario inserire un'immagine.",
                    },
                },
            });
            $('#appForm input').on('keyup blur click', function() {
                if ($('#appForm').validate().checkForm()) {
                    $('#submit').prop('disabled', false).removeClass('ms_btn_disabled');
                } else {
                    $('#submit').prop('disabled', true).addClass('ms_btn_disabled');
                }
            });
        });
    </script>

    <style>
        label.error {
            margin-top: 0.5rem;
            font-size: 11px;
            color: red;
        }

        .ms_btn_disabled {
            opacity: 0.1;
        }
    </style>
@endsection
