@extends('layouts.backOffice')

@section('content')
    <section class="container-fluid" id="apartment-messages">
        <div class="row p-5">
            <div class="col-12">
                <h3 class="pb-3">
                    Messaggi per l'appartamento <a href="{{ route('registered.apartments.show', $apartment) }}">{{ $apartment->title }}</a>:
                </h3>
            </div>
            @if(count($messages) == 0)
                <p>Nessun messaggio per questo appartamento.</p>
            @else
            @foreach ($messages as $message)
            <div class="col-12 col-lg-6 gx-5 gy-3">
                <div class="alert alert-dark box-message p-4 h-100">
                    <div class="alert-top">
                        <h4 class="message-author">{{ ucFirst($message->guest_name) }} chiede</h4>
                        <p class="message-date">{{ $message->created_at }}</p>
                        <div class="content">
                            <p class="message">{{ $message->content }}</p>
                        </div>
                    </div>
                    <textarea rows="3" class="form-control" placeholder="Rispondi..."></textarea>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </section>

@endsection
