@extends('layouts.backOffice')

@section('content')
    <div class="container-fluid m-auto w-75">
        <div class="row justify-content-center">
            @foreach ($apartments as $apartment)

                <div class="card col-2 mx-2 p-0">
                    <a href="{{ route('registered.apartments.show', $apartment) }}">
                        @if(str_starts_with($apartment->image_path, 'http://') || str_starts_with($apartment->image_path, 'https://')  )
                            <img class="card-img-top h-50" src="{{ $apartment->image_path }}" alt="Card image cap">
                        @else
                            <img class="card-img-top h-50" src="{{ asset('/storage') . '/' .$apartment->image_path}}" alt="Card image cap">
                        @endif
                    </a>

                    <div class="card-body">
                        <h5 class="card-title"> {{$apartment->title}} </h5>
                        <p class="card-subtitle"> {{ $apartment->address }} </p>
                        <div class="d-flex">
                            <a class="btn btn-primary" href="{{ route('registered.apartments.edit', $apartment) }}">modifica</a>
                            <form action="{{route('registered.apartments.destroy', $apartment)}}" class="col-3 blackhole" method="POST" apartment-title="{{ucwords($apartment->title)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
    const blackHole = document.querySelectorAll('.blackhole');
    blackHole.forEach(singleForm => {
        singleForm.addEventListener('submit', function (event) {
            event.preventDefault(); //acchiappo l'invio del form
            userConfirm = window.confirm(`Sei sicuro di voler eliminare ${this.getAttribute('apartment-title')}`);
            if(userConfirm) {
                this.submit();
            }
        })
    });
    </script>
@endsection
