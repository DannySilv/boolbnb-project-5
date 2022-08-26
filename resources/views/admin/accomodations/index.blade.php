@extends('layouts.dashboard')

@section('content')
    <h1>Accomodations List</h1>
    <div class="row row-cols-3">
        @foreach ($accomodations as $accomodation)
            {{-- Single accomodation --}}
            <div class="col">
                <div class="card mb-3" style="width: 18rem;">
                    @if ($accomodation->image)
                        <img class="card-img-top" src="{{ asset('storage/' . $accomodation->image) }}" alt="Card image cap">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $accomodation->name }}</h5>
                        <a href="{{ route('admin.accomodations.show', ['accomodation' => $accomodation->id]) }}"
                            class="btn btn-primary">Open accomodation</a>
                    </div>
                </div>
            </div>
            {{-- /Single Accomodation --}}
        @endforeach
    </div>
    {{-- {{ $accomodations->links() }} --}}
@endsection
