@extends('layouts.backOffice')

@section('content')
<div class="my-show-container m-auto py-5">
    <div class="row">
        <div class="col-12">
            @if (session('sponsor-success-message'))
                <div class="alert alert-success">
                    {{session('sponsor-success-message')}}
                </div>
            @endif
            <div>
                <h1>{{ucFirst($apartment->title)}}</h1>
                <h4>{{$apartment->address}}</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-6 col-md-12 pe-0">
            <img class="show-main-image img-fluid" src="{{ isset($apartment->apartment_images[0]->image_path) ?  asset('storage'.'/'. $apartment->apartment_images[0]->image_path) : asset('images/placeholder.png') }}" alt="image">
        </div>
        <div class="col-lg-6 col-md-12">
            <ul class="row gallery">
                @foreach ($apartment->apartment_images as $image)
                    <li class="col-lg-6 col-md-3">
                        <img class="show-side-images" src="{{ asset('storage'.'/'. $image->image_path) }}" alt="image">
                    </li>
                @endforeach
            </ul>
            @if(count($apartment->apartment_images) > 6)
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="more btn">Show more</div>
                <div class="less btn">Show less</div>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <!-- Colonna descrizione -->
        <div class="col-12 col-lg-8">
            <h3>Descrizione</h3>
            <p>{{$apartment->description}}</p>
        </div>
        <!-- Colonna ripilogo offerta -->
        <div class="col-12 col-lg-4">
            <div class="card card-show">
                <div class="card-body">
                    <h4 class="card-title text-center bb-magenta pb-3"><strong>{{$apartment->price_per_night}}</strong>&euro; /notte</h4>
                    <div class="d-flex justify-content-between mx-2">
                        <h5 class="card-text fw-bold">Stanze:</h5>
                        <h5 class="card-text">{{$apartment->rooms_number}}</h5>
                    </div>
                    <div class="d-flex justify-content-between mx-2">
                        <h5 class="card-text fw-bold">Bagni:</h5>
                        <h5 class="card-text">{{$apartment->bathrooms_number}}</h5>
                    </div>
                    <div class="d-flex justify-content-between mx-2">
                        <h5 class="card-text fw-bold">Letti:</h5>
                        <h5 class="card-text">{{$apartment->beds_number}}</h5>
                    </div>
                    <div class="d-flex justify-content-between mx-2">
                        <h5 class="card-text fw-bold">M<sup>2</sup>:</h5>
                        <h5 class="card-text">{{$apartment->square_meters}}</h5>
                    </div>
                </div>
            </div>
            <div class="card card-show card-btn">
                <a href="{{ route('registered.messages.show', $apartment->id) }}">Centro Messaggi</a>
            </div>
            <div class="card card-show card-btn">
                <a href="{{ route('registered.apartments.edit', $apartment) }}">Modifica Annuncio</a>
            </div>
            <div class="card card-show card-btn">
                <a href="{{ route('payments.index', $apartment->id) }}">Sponsorizza <i class="fas fa-money-check"></i></a>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            @if( count($apartment->services) > 0 )
            <div id="services">
                <h3 class="mt-5">Servizi Inclusi</h3>
                @foreach($apartment->services as $service)
                <span class="badge rounded-pill bg-magenta me-2 mb-1">{{ $service->name }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('.gallery li:lt(6)').show();
        $('.less').hide();
        let items =  10;
        let shown =  6;
        $('.less').click(function () {
            $('.gallery li').not(':lt(6)').hide(300);
            $('.more').show();
            $('.less').hide();
        });
        $('.more').click(function () {
            $('.less').show();
            shown = $('.gallery li:visible').length+6;
            if(shown< items) {
            $('.gallery li:lt('+shown+')').show(300);
            } else {
            $('.gallery li:lt('+items+')').show(300);
            $('.more').hide();
            }
        });
    });
    let checkIn = document.getElementById('check-in');
    let checkOut = document.getElementById('check-out');
</script>
@endsection
