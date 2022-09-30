@extends('layouts.dashboard')

@section('content')
<h1 class="mb-5">Sponsor per "{{ $accomodation->name }}"</h1>
<div class="row row-cols-3">
    @foreach ($sponsors as $sponsor)
            <div class="col">
                <div class="card mb-3" style="width: 17rem; height: 370px">
                    <div class="card-body">
                        <h4 class="card-title">{{ $sponsor->name }}</h4>
                        <h3>{{ $sponsor->price }}</h3>
                        <h5>{{ $sponsor->number_of_hours }}</h5>
                        <a href="{{ route('admin.sponsors.payment', [$accomodation, $sponsor]) }}"
                            class="btn btn-primary my-3">Acquista</a>
                    </div>
                </div>
            </div>
    @endforeach
</div>
@endsection