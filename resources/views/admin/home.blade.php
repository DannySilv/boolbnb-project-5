@extends('layouts.dashboard')

@section('content')
    <h3 class="mt-2 mb-4"> Ciao {{ $user->name }}, hai effettuato l'accesso correttamente. </h3>
    <a href="{{ route('admin.accomodations.index') }}">
        Visualizza i tuoi appartamenti
    </a>

@endsection
