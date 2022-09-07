@extends('layouts.dashboard')

@section('content')
    <h3 class="mx-2 pt-4" style="margin-bottom: 100px"> Ciao {{ $user->name }}, hai effettuato l'accesso correttamente. </h3>
    {{-- <a href="{{ route('admin.accomodations.index') }}">
        Visualizza i tuoi appartamenti
    </a> --}}

@endsection
