@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-5">I miei appartamenti</h1>
    <div class="row text-center d-flex flex-wrap row-cols-xl-4 row-cols-lg-3 row-cols-md-2">
        @foreach ($accomodations as $accomodation)
                {{-- Single accomodation --}}
                <div class="col">
                    <div class="card mb-5 mx-auto mx-3" style="width: 17rem; height: 370px; border-radius: 20px">
                        @if ($accomodation->image)
                            <img class="card-img-top h-50" src="{{ asset('storage/' . $accomodation->image) }}"
                                alt="Card image cap" style="overflow:hidden; border-top-left-radius: 20px; border-top-right-radius: 20px">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $accomodation->name }}</h5>
                            @if ($accomodation->is_visible == 0)
                                <small>L'appartamento è attualmente nascosto</small>
                            @endif
                            <a href="{{ route('admin.accomodations.show', ['accomodation' => $accomodation->id]) }}"
                                class="btn btn-primary my-3">Dettagli appartamento</a>
                        </div>
                    </div>
                </div>
                {{-- /Single Accomodation --}}
        @endforeach
    </div>
   
    {{-- {{ $accomodations->links() }} --}}
@endsection
