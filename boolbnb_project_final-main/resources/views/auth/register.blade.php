@extends('layouts.backOffice')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Registrati') }}</div>

                <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                    <form id="submit-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row my-1 ax-wrapper" name='first_name'>
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('Nome*') }}</label>

                            <div class="col-md-6" >
                                <input id="first_name" type="text" class="form-control"  name="first_name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row my-1 ax-wrapper" name="last_name">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Cognome*') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-1 ax-wrapper" name="email">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail*') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- date --}}
                        <div class="form-group row my-1 ax-wrapper" name="date_of_birth">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita*') }}</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- telefono --}}
                        <div class="form-group row my-1 ax-wrapper" name="phone_nr">
                            <label for="phone_nr" class="col-md-4 col-form-label text-md-right">{{ __('Recapito telefonico') }}</label>

                            <div class="col-md-6">
                                <input id="phone_nr" type="tel" class="form-control @error('phone_nr') is-invalid @enderror" name="phone_nr" value="{{ old('phone_nr') }}" required autocomplete="phone_nr">

                                @error('phone_nr')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-1 ax-wrapper" name="password">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password*') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-1 ax-wrapper" name="password_confirmation">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password*') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="my-3">
                            <p>I campi contrassegnati da * sono obbligatori</p>
                        </div>
                        <div class="form-group row mb-0 ax-wrapper mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button id="submit" type="submit" class="btn">
                                    {{ __('Registrati') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        let submitButton = document.getElementById('submit');
        let checkErrors = {};
        submitButton.addEventListener('click',function(event){
            const errors = {};
            
            const stringErrors = document.querySelectorAll(".string-error");
            stringErrors.forEach(element => {
            element.remove()
            });

            //tentative time+age checks
            if((date_of_birth.value.trim() === "")){
                errors.date_of_birth = 'Inserisci una data di nascita';
            }
            if(date_of_birth.value){
                const adulthood = moment().subtract(18 , 'years')
                if(moment(date_of_birth.value).isAfter(adulthood)){
                    console.warn(moment().diff(date_of_birth.value, 'years'))
                    console.error(date_of_birth.value);
                    errors.date_of_birth = 'Mi spiace, devi essere maggiorenne per poterti iscrivere al sito';
                }
            }

            //working set of checks
            if((first_name.value.trim() === "") || (first_name.value.trim().length < 3) || (first_name.value.trim().length > 100)){
                errors.first_name = 'Inserisci un nome test';
            }
            if((last_name.value.trim() === "") || (last_name.value.trim().length < 3) || (last_name.value.trim().length > 100)){
                errors.last_name = 'Inserisci un cognome test';
            }
            if((password.value.trim() === "") || (password.value.trim().length <= 7) || (password.value.trim().length > 16)){
                errors.password = 'Inserisci una password tra 8 e 16 caratteri';
            }
            if((!email.value.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))){
                errors.email = 'Nope'
            }
            const confirm = document.getElementById('password-confirm')
            if((confirm.value.trim() !== password.value.trim())){
                errors.password_confirmation = 'Le password non corrispondono';
            }

            for (const key in errors) {
            const parents = document.querySelectorAll('.ax-wrapper')
            parents.forEach(parent => {
                let attribute = parent.getAttribute('name');
                if(key == attribute){
                    const errorSpan = document.createElement("span");
                    errorSpan.classList.add("text-danger", "string-error");
                    errorSpan.innerHTML = errors[key];
                    parent.appendChild(errorSpan);
                }
            });
            }

            checkErrors = errors;
            if(Object.keys(checkErrors).length !== 0){
            event.preventDefault();
            }
            
        });
    </script> --}}
<script src="{{ asset('js/userValidation.js') }}"></script>
@endsection