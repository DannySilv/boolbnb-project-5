@extends('layouts.dashboard')

@section('content')
    @if (count($messages) == 0)
        <p>Non ci sono messaggi ricevuti</p>
    @else
        <h2>Lista messaggi ricevuti:</h2>
        <ul class="p-3">
            @foreach ($messages as $message)
                <li class="my-2">
                    <div class="card">
                        <p>Nome: {{ $message->user_name }}</p>
                        <p>Cognome: {{ $message->user_surname }}</p>
                        <p>Indirizzo email: {{ $message->email }}</p>
                        <p>Testo messaggio: {{ $message->message_text }}</p>
                        <div>Il messaggio fa riferimento all'appartamento:
                            {{ $accomodations[$message->accomodation_id - 1]->name }}
                            <a href="{{ route('admin.accomodations.show', ['accomodation' => $accomodations[$message->accomodation_id - 1]]) }}"
                                class="">Vedi l'appartamento</a>
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
