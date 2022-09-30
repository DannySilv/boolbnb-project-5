@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center mb-5">I miei appartamenti</h1>
    <div class="row text-center d-flex flex-wrap row-cols-xl-4 row-cols-lg-3 row-cols-md-2">
        @foreach ($accomodations as $accomodation)
            {{-- Single accomodation --}}
            <div class="col">
                <div class="my_card card mb-5 mx-auto mx-3">
                    @if ($accomodation->image)
                        <img class="card-img-top h-50" src="{{ asset('storage/' . $accomodation->image) }}"
                            alt="Card image cap" style="overflow:hidden;">
                        @if (isset($accomodation->sponsor_plans[0]->pivot->expiring_date) && $accomodation->sponsor_plans[0]->pivot->expiring_date > date("Y-m-d H:i:s"))  
                            @if ($accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 1)
                            <button class="btn btn-success ms-position-index" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @elseif ($accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 2)
                            <button class="btn btn-secondary ms-position-index" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @elseif ($accomodation->sponsor_plans[0]->pivot->sponsor_plan_id == 3)
                            <button class="btn btn-warning ms-position-index" disabled>
                                <i class="fas fa-star"></i>
                            </button>
                            @endif
                        @endif
                    @endif
                    <div class="card_body">
                        <h5 class="card-title text-center py-3">{{ $accomodation->name }}</h5>
                        <div>
                            <div class="details">
                                <span class="n-rooms animated zoomIn"><i class="fas fa-vector-square"></i>
                                    {{ $accomodation->size_sqm }} m<sup>2</sup>
                                </span>
                                <span class="n-beds animated zoomIn"><i class="fas fa-shower"></i>
                                    {{ $accomodation->n_bathrooms }}
                                </span>
                            </div>
                            <div class="details">
                                <span class="n-baths animated 	zoomIn"><i class="fas fa-bed"></i>
                                    {{ $accomodation->n_beds }}</span>
                                <span class="size animated 	zoomIn"><i class="fas fa-door-closed"></i>
                                    {{ $accomodation->n_rooms }}</span>
                            </div>
                        </div>
                        @if ($accomodation->is_visible == 0)
                            <small>L'appartamento è attualmente nascosto</small>
                        @endif
                        <a href="{{ route('admin.accomodations.show', ['accomodation' => $accomodation->id]) }}"
                            class="index_btn btn btn-danger mt-4">Dettagli appartamento
                        </a>
                    </div>
                </div>
            </div>
            {{-- /Single Accomodation --}}
        @endforeach
    </div>

    {{-- {{ $accomodations->links() }} --}}
@endsection
