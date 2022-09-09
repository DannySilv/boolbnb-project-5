@extends('layouts.dashboard')

@section('content')
    <h2>Lista messaggi ricevuti:</h2>

    @if ($messages)
        <ul class="p-3">
            @foreach ($messages as $message)
                <li class="my-2">
                    <div class="card">
                        <p>Nome: {{ $message->user_name }}</p>
                        <p>Cognome: {{ $message->user_surname }}</p>
                        <p>Indirizzo email: {{ $message->email }}</p>
                        <p>Testo messaggio: {{ $message->message_text }}</p>
                        <p>Il messaggio fa riferimento all'appartamento {{ $message->accomodation_id }}</p>

                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Non ci sono messaggi ricevuti</p>
    @endif
@endsection
