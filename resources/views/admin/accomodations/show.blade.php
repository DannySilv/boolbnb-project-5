@extends('layouts.dashboard')

@section('content')
    @if ($current_accomodation->user_id == $user_id)
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="container">
            <div class="row align-items-center">
                {{-- Colonna immagine --}}
                <div class="col-lg-8 col-xs-12">
                    @if ($current_accomodation->image)
                        <img class="acc_image w-100 rounded" style="max-height: 450px; object-fit:cover;"
                            src="{{ asset('storage/' . $current_accomodation->image) }}"
                            alt="{{ $current_accomodation->name }}">
                        @if (isset($current_accomodation->sponsor_plans[0]->pivot->expiring_date) && $current_accomodation->sponsor_plans[0]->pivot->expiring_date > date("Y-m-d H:i:s"))  
                            @if ($current_accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 1)
                            <button class="btn btn-success ms-position" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @elseif ($current_accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 2)
                            <button class="btn btn-secondary ms-position" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @elseif ($current_accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 3)
                            <button class="btn btn-warning ms-position" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @endif
                        @endif
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
                    <div class="d-flex justify-content-between mt-3">
                        <div class="btn_hov">
                            <a class="edit_btn btn"
                                href="{{ route('admin.accomodations.edit', ['accomodation' => $current_accomodation->id]) }}">
                                Modifica
                            </a>
                        </div>

                        <form class="btn_hov"
                            action="{{ route('admin.accomodations.destroy', ['accomodation' => $current_accomodation->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="delete_btn btn" onclick="return confirm('Sei sicuro?')">
                                Elimina
                            </button>
                            <p class="d-none"></p>
                        </form>
                        <div class="btn_hov">
                            <a class="btn sponsor_btn"
                                href="{{ route('admin.sponsors', $current_accomodation->id) }}">
                                Sponsorizza
                            </a>
                        </div>
                    </div>
                    {{-- / delete-destroy button --}}
                    <div class="mt-3">
                        @if ($current_accomodation->sponsor_plans[0]->pivot->expiring_date > date("Y-m-d H:i:s"))
                            <h6>Il periodo di sponsorizzazione termina tra:</h6>
                            <div class="d-flex align-items-center">
                                <div id="days" class="d-flex align-items-center"></div>
                                <div id="hours" class="d-flex align-items-center"></div>
                                <div id="minutes" class="d-flex align-items-center"></div>
                                <div id="seconds" class="d-flex align-items-center"></div>
                            </div>
                        @endif
                    </div>
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
    <script>
        let loading = true;
        let timer = function (date) {
            this.loading = false;
            let timer = Math.round(new Date(date).getTime()/1000) - Math.round(new Date().getTime()/1000);
            let minutes;
            let seconds;
            setInterval(function () {
                if (--timer < 0) {
                    timer = 0;
                }
                days = parseInt(timer / 60 / 60 / 24, 10);
                hours = parseInt((timer / 60 / 60) % 24, 10);
                minutes = parseInt((timer / 60) % 60, 10);
                seconds = parseInt(timer % 60, 10);

                days = days < 10 ? "<h4>0" + days + "</h4>" + "<span>D</span>" : "<h4>" + days + "</h4>" + "<span>D</span>";
                hours = hours < 10 ? "<h4>0" + hours + "</h4>" + "<span>H</span>" : "<h4>" + hours + "</h4>" + "<span>H</span>";
                minutes = minutes < 10 ? "<h4>0" + minutes + "</h4>" + "<span>M</span>" : "<h4>" + minutes + "</h4>" + "<span>M</span>";
                seconds = seconds < 10 ? "<h4>0" + seconds + "</h4>" + "<span>S</span>" : "<h4>" + seconds + "</h4>" + "<span>S</span>";

                document.getElementById('days').innerHTML = days;
                document.getElementById('hours').innerHTML = hours;
                document.getElementById('minutes').innerHTML = minutes;
                document.getElementById('seconds').innerHTML = seconds;
            }, 1000);
        }
    
        //using the function
        const endSponsor = new Date("{{ $current_accomodation->sponsor_plans[0]->pivot->expiring_date }}");
        console.log(endSponsor);
        timer(endSponsor);
    </script>
@endsection
