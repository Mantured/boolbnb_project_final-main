<?php use Carbon\Carbon ; ?>
@extends('layouts.backOffice')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2>Benvenuto...</h2>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body p-5">
                    <div class="card-top text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                        class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3">{{ ucfirst(Auth::user()->first_name)}} {{ ucfirst(Auth::user()->last_name) }}</h5>
                    </div>
                    <div class="card-description my-4">
                        <p class="mb-0 "><span class="fw-bold">Email: </span> {{ Auth::user()->email }}</p>
                        <p class="mb-0 "><span class="fw-bold">Telefono: </span> {{ Auth::user()->phone_nr }}</p>
                        <p class="text-muted">Attualmente hai aggiunto {{count($apartments)}} appartamenti.</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-outline-primary" href="{{ route('registered.apartments.create') }}">Aggiungi Appartamento</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Prova grafico statistiche --}}
        {{-- <div class="col-lg-8">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-center">{{ __('Dashboard') }} - {{ ucfirst(Auth::user()->first_name) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error-message'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error-message') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="col table-titolo">Titolo</th>
                                <th class="col table-indirizzo">Indirizzo</th>
                                <th class="col table-metri2">M<sup>2</sup></th>
                                <th class="col table-prezzo">Prezzo</th>
                                <th class="col table-disponibilita text-center">Disponibilità</th>
                            </tr>
                        </thead>
                        @forEach($apartments as $apartment)

                        <tbody>
                            <tr class="{{ $apartment->is_visible == '0' ? 'bg-danger text-white' : '' }}">
                                <td class="table-titolo">
                                    @if(strlen($apartment->title) > 10)
                                        {{substr_replace($apartment->title, '...', 10) }}
                                    @else
                                    {{$apartment->title}}
                                    @endif
                                    <div class="image-span">
                                        <a href="{{ route('registered.apartments.show', $apartment) }}">
                                            <img src="{{ isset($apartment->apartment_images[0]->image_path) ?  asset('storage'.'/'. $apartment->apartment_images[0]->image_path) : asset('images/placeholder.png') }}" alt="Image of apartment">
                                        </a>
                                    </div>
                                </td>
                                <td class="table-indirizzo">
                                    <a href="{{ route('registered.apartments.show', $apartment) }}" class="text-decoration-none text-black">
                                        @if(strlen($apartment->address) > 20)
                                        {{substr_replace($apartment->address, '...', 20) }}
                                        @else
                                        {{$apartment->address}}
                                        @endif
                                    </a>
                            <span class="ax-sponsored ms-3 rounded-pill
                                @if(count($apartment->sponsorships) > 0)
                                    @foreach ($apartment->sponsorships as $isSponsored)
                                        @if (Carbon::parse($isSponsored->pivot->ending_time) > Carbon::now())
                                        {{-- nessuna condizione --}}
                                        @elseif (Carbon::parse($isSponsored->pivot->ending_time) < Carbon::now())
                                        {{-- nascondo la vista dello span --}}
                                        {{ ' d-none' }}
                                        
                                        @endif

                                    @endforeach
                                @else
                                {{ ' d-none' }}
                                @endif">
                                Sponsorizzato
                                </span>
                                </td>
                                <td class="table-metri2">{{$apartment->square_meters}}M<sup>2</sup></td>
                                <td class="table-prezzo">{{$apartment->price_per_night}}€ /notte</td>
                                @if($apartment->is_visible == '1')
                                    <td  class="text-center table-disponibilita">Disponibile</td>
                                @elseif($apartment->is_visible == '0')
                                    <td  class="text-center table-disponibilita">Non disponibile</td>
                                @endif
                                <td >
                                    <div class="dashboard-btn blue">
                                        <a class="fas fa-edit" href="{{ route('registered.apartments.edit', $apartment) }}">
                                        </a>
                                    </div>
                                    <form class="dashboard-btn red blackhole"
                                    action="{{route('registered.apartments.destroy', $apartment)}}"
                                    method="POST" apartment-title="{{ucwords($apartment->title)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="fas fa-trash my-delete"></button>
                                    </form>
                                    <div class="dashboard-btn blue">
                                        <a class="fas fa-comment-alt" href="{{ route('registered.messages.show', $apartment->id) }}"></a>
                                    </div>
                                    <div class="dashboard-btn blue">
                                        <a class="fas fa-money-check" href="{{ route('payments.index', $apartment->id) }}"></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    const blackHole = document.querySelectorAll('.blackhole');
        for (let i = 0; i < blackHole.length; i++) {
            blackHole[i].addEventListener('submit', function(event) {
                event.preventDefault();
                const form = event.target.form;
                Swal.fire({
                    title: 'Vuoi Cancellare?',
                    text: "Attenzione non è possibile tornare indietro!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, procedi!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                            'Cancellato!',
                            'Appartamento cancellato con successo.',
                            'success'
                            );
                            this.submit();
                        }
                    })
            })
        }
    </script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
console.log(Chart);

const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }

        }
    }
});
</script> --}}
@endsection
