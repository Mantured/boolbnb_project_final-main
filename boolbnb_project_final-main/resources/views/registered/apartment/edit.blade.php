@extends('layouts.backOffice')
@section('title', 'Modifica Appartamento')

@section('content')
    <div class="my-container my-5 m-auto">
        <h2 class="text-center pt-4 mb-5">Modifica Appartamento</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="wrapper-form">
            <form id="submit-form" action="{{ route('registered.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @Method('PUT')
                <div class="mb-3 ax-wrapper" name="title">
                    <label for="title">Titolo*</label>
                    <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title') ?? $apartment->title }}">
                </div>
                <div class="mb-3 ax-wrapper" name="description">
                    <label for="description">Descrizione*</label>
                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') ?? $apartment->description }}</textarea>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="beds_number">
                        <label for="beds_number">Numero Letti*</label>
                        <input type="number" name="beds_number" id="beds_number" class="form-control"
                        value="{{ (old('beds_number')) ?? $apartment->beds_number }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="rooms_number">
                        <label for="rooms_number">Numero Camere*</label>
                        <input type="number" name="rooms_number" id="rooms_number" class="form-control"
                        value="{{ (old('rooms_number')) ?? $apartment->rooms_number }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="bathrooms_number">
                        <label for="bathrooms_number">Numero Bagni*</label>
                        <input type="number" name="bathrooms_number" id="bathrooms_number" class="form-control"
                        value="{{ (old('bathrooms_number')) ?? $apartment->bathrooms_number }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="square_meters">
                        <label for="square_meters">Metri quadrati*</label>
                        <input type="number" name="square_meters" id="square_meters" class="form-control"
                        value="{{ (old('square_meters')) ?? $apartment->square_meters }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="price_per_night">
                        <label for="price_per_night">Prezzo a notte*</label>
                        <input type="number" name="price_per_night" id="price_per_night" class="form-control"
                        step=".01"
                        placeholder="14.99"
                        value="{{ (old('price_per_night')) ?? $apartment->price_per_night }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="is_visible">
                        <label for="is_visible">Disponibilità</label>
                        <select name="is_visible" id="is_visible" class="form-select">
                            <option
                                value="0" {{old('is_visible') == 0 ||  $apartment->is_visible == 0 ? 'selected' : ''}}>
                                Non disponibile
                            </option>
                            <option
                                value="1" {{old('is_visible') == 1 ||  $apartment->is_visible == 1 ? 'selected' : ''}}>
                                Subito disponibile
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 ax-wrapper position-relative" name="address">
                    <label for="address">Indirizzo*</label>
                    <input type="text" name="address" id="address" class="form-control" autocomplete="off" value="{{ old('address') ?? $apartment->address }}">
                    <ul id="result_address" class="position-absolute d-none w-100">
                        {{-- Viene popolata dinamicamente con la chiamata axios --}}
                    </ul>
                </div>
                <div class="mb-3 ax-wrapper" name="image_path">
                    <label for="image_path">Immagine post*</label>
                    <input type="file" name="image[]" id="image_path" class="form-control" value="{{ old('image') }}" multiple="multiple">
                </div>
                <div class="mb-3 prewiew-images">
                    @foreach ($apartment->apartment_images as $image)
                        <div class="image-span" id="{{$image->id}}">
                            <img src="{{ asset('storage'.'/'. $image->image_path) }}" alt="image">
                            <input type="hidden" id="old_images" name="old_images[]" value="{{ $image->image_path }}">
                            <i class="fas fa-times" onClick="deleteImage({{$image->id}})" id="delete-image"></i>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3 ax-wrapper d-flex flex-wrap">
                    @foreach ($services as $service)
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <input type='checkbox' value="{{ $service->id }}" name='service[]' {{ (old("service") && in_array($service->id , old("service"))) || (!old("service") && $apartment->services->contains($service)) ? 'checked' : ''}}>
                            <label for="service" class="form-label badge rounded-pill mb-1 text-black-50" style='font-size: .6rem;'>
                                    {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <p>I campi contrassegnati da * sono obbligatori</p>
                </div>
                <input type="hidden" name="latitude" id="latitude"
                    value="{{ (old('latitude')) ?? $apartment->latitude }}">
                <input type="hidden" name="longitude" id="longitude"
                    value="{{ (old('longitude')) ?? $apartment->longitude }}">
                <button id="submit" type="submit" class="btn">Modifica</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
{{-- # Script per eliminare le immagini da front-end --}}
<script>
function deleteImage(id){
    document.getElementById(id).remove();
    console.log(`Hai cancellato ${id}`);
}
</script>
<script src="{{ asset('js/addressInfo.js') }}"></script>
<script src="{{ asset('js/editValidation.js') }}"></script>

@endsection
