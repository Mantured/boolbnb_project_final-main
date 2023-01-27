@extends('layouts.backOffice')
@section('title', 'Aggiungi Appartamento')

@section('content')
    <div class="my-container my-5 m-auto">
        <h2 class="text-center pt-4 mb-5">Aggiungi Appartamento</h2>
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
            <form id="submit-form" action="{{ route('registered.apartments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @Method('POST')
                <div class="mb-3 ax-wrapper" name='title'>
                    <label for="title">Annuncio*</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Inserisci un titolo per l'annuncio del tuo alloggio">
                </div>
                <div class="mb-3 ax-wrapper" name='description'>
                    <label for="description">Descrizione dell'alloggio*</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Descrivi il tuo alloggio.." >{{ old('description') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="beds_number">
                        <label for="beds_number">Numero dei letti disponibili*</label>
                        <input type="number" name="beds_number" id="beds_number" class="form-control" 
                        placeholder=""
                        value="{{ (old('beds_number')) ? old('beds_number') : 1 }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="rooms_number">
                        <label for="rooms_number">Numero delle camere da letto*</label>
                        <input type="number" name="rooms_number" id="rooms_number" class="form-control" 
                        placeholder=""
                        value="{{ (old('rooms_number')) ? old('rooms_number') : 1 }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="bathrooms_number">
                        <label for="bathrooms_number">Numero dei bagni*</label>
                        <input type="number" name="bathrooms_number" id="bathrooms_number" class="form-control" 
                        placeholder=""
                        value="{{ (old('bathrooms_number')) ? old('bathrooms_number') : 1 }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="square_meters">
                        <label for="square_meters">Metri quadrati*</label>
                        <input type="number" name="square_meters" id="square_meters" class="form-control" 
                        placeholder=""
                        value="{{ (old('square_meters')) ? old('square_meters') : 20 }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="price_per_night">
                        <label for="price_per_night">Prezzo a notte*</label>
                        <input type="number" name="price_per_night" id="price_per_night" class="form-control" 
                        step=".01"
                        value="{{ (old('price_per_night')) ? old('price_per_night') : "14.99" }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ax-wrapper" name="is_visible">
                        <label for="is_visible">Disponibilità</label>
                        <select name="is_visible" id="is_visible" class="form-select">
                            <option value="0">Non ancora disponibile</option>
                            <option value="1" selected>Subito disponibile</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 ax-wrapper position-relative" name="address">
                    <label for="address">Indirizzo*</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" autocomplete="off" placeholder="Inserisci il nome del tuo appartamento">
                    <ul id="result_address" class="position-absolute d-none w-100">
                        {{-- Viene popolata dinamicamente con la chiamata axios --}}
                    </ul>
                </div>
                <div class="mb-3 ax-wrapper" name="image_path">
                    <label for="image_path">Immagine dell'alloggio*</label>
                    <input type="file" name="image_path[]" id="image_path" class="form-control" 
                    value="{{ old('image_path') }}" multiple="multiple">
                </div>
                <div class="mb-3 ax-wrapper d-flex flex-wrap">
                    @foreach ($services as $service)
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <input type='checkbox' value="{{ $service->id }}" name='service[]' {{ old("service") && in_array($service->id , old("service")) ? 'checked' : ''}}>
                            <label for="service" class="form-label badge rounded-pill mb-1 text-black-50" style='font-size: .6rem;'>
                                    {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <p>I campi contrassegnati da * sono obbligatori</p>
                </div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <button id="submit" type="submit" class="btn">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('js/addressInfo.js') }}"></script>
<script src="{{ asset('js/aptValidation.js') }}"></script>
@endsection
