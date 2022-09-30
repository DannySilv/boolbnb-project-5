@extends('layouts.dashboard')

@section('content')
    <h3 class="text-center mt-5"> Bentornato {{ $user->name }}!</h3>
    {{-- <a href="{{ route('admin.accomodations.index') }}">
        Visualizza i tuoi appartamenti
    </a> --}}

@endsection
