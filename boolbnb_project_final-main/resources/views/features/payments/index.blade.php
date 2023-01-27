
@extends('layouts.backOffice')

@section('content')
    @if (session('success-message'))
        <div class="alert alert-success">
            {{session('success-message')}}
        </div>
    @endif
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{$error}}
            </div>
        @endforeach
    @endif
    <div class="container-fluid px-5">
        <div class="row p-5">
            <div class="col-12 ms-auto p-5 ax-rounded shadow">
                <div class="px-5">
                    <h4>L'alloggio selezionato per la sponsorizzazione: {{ $apartment->title }}</h4>
                    <h6>Indirizzo: {{ $apartment->address }}</h6>
                </div>
                <div class="p-5">
                    <h3>I nostri piani tariffari:</h3>
                    @foreach($sponsorships as $sponsorship)
                    <p>Sponsorizza il tuo alloggio per {{ $sponsorship->durations }} ore* con il nostro pacchetto <span class="text-success">{{ $sponsorship->name }}</span>, al prezzo di {{ $sponsorship->price }}&euro;!</p>
                    @endforeach
                    <p class="fst-italic">*Nel caso di una sponsorizzazione già in corso, il tempo della nuova sponsorizzazione verrà aggiunto a quella precedente.</p>
                </div>
            </div>
            <div class="col-12 p-5">
                <div class="d-flex justify-content-center">
                    <form method="post" class="w-50 shadow ax-rounded p-5" id="payment-form" action="{{ route('payments.checkout')}}">
                        @csrf
                        <section>
                            <label for="amount">
                                <span class="input-label">Selezione Piano</span>
                                <select  id="id" name="id" class="text-capitalize form-select form-select-sm" aria-label=".form-select-sm example">
                                    @foreach ( $sponsorships as $sponsorship )
                                    <option  @if($sponsorship->id == 1) {{ 'selected' }} @endif  value="{{$sponsorship->id}}">{{ucfirst($sponsorship->name)}} : {{$sponsorship->price}}&euro;</option>
                                    @endforeach
                                </select>
                            </label>
            
                            <div class="bt-drop-in-wrapper">
                                <div id="bt-dropin"></div>
                            </div>
                        </section>
            
                        <input id="apartment" type="hidden" name="apartment" value="{{$apartment->id}}">
                        <input id="nonce" name="payment_method_nonce" type="hidden" />
                        <button class="btn btn-info" type="submit"><span>Paga ora!</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script  src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";
        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
            paypal: {
                flow: 'vault'
            }
        }, function (createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                }
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
                });
            });
        });
    </script>
@endsection
