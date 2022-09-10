@extends('layouts.dashboard')

@section('content')
    @if (count($messages) == 0)
        <p>Non ci sono messaggi ricevuti</p>
    @else
        <h2>Lista messaggi ricevuti:</h2>
        <ul class="p-3" style="width: 80%; color:rgb(103, 102, 102)">
            @foreach ($messages as $message)
                <li class="my-2 p-2">
                    <div class="card"
                        style="border-top: 1px solid #ff395d88; 
                    border-left: 1px solid lightgray;
                    border-right: 1px solid lightgray;
                    border-bottom: 1px solid lightgray">
                        <div class="p-2 d-flex justify-content-between" style="background: rgb(248,249,250);
                            background: linear-gradient(0deg, rgba(248,249,250,0.5) 0%, rgba(255,57,92,.3) 100%);
                            line-height:3em">
                            <p class="mb-0 mr-5" style="font-size: 1.3rem">{{ $message->user_name }}
                                {{ $message->user_surname }}</p>
                            <span class="mb-0" style="font-size: 1rem; color: gray;">{{ $message->email }}</span>
                            {{-- <p class="mb-0" style="font-size: 1.2rem; color: gray; text-align: right">{{ $message->email }}</p> --}}
                        </div>
                        <div class="p-2">
                            <p style="min-height:100px; font-size:1rem">{{ $message->message_text }}</p>
                        </div>
                    </div>
                    <div class="p-2">Il messaggio fa riferimento all'appartamento:
                        {{ $accomodations[$message->accomodation_id - 1]->name }}
                        <a href="{{ route('admin.accomodations.show', ['accomodation' => $accomodations[$message->accomodation_id - 1]]) }}"
                            class="">Vedi l'appartamento</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
