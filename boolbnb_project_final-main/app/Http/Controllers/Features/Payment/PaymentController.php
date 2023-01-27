<?php

namespace App\Http\Controllers\Features\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\Sponsorship;
use App\Model\Apartment;
use App\Model\Message;
use Braintree\Gateway;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PaymentController extends Controller
{
    public function index($id)
    {

        $apartment = Apartment::findOrFail($id);
        $sponsorships = Sponsorship::all();

        if (!isset(Auth::user()->id)){
            return redirect()->route('login')->with('error-message', 'Devi fare l\'accesso per poter accedere');
        }

        if ($apartment->user_id !== Auth::user()->id) {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }

        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $token = $gateway->ClientToken()->generate();
        return view('features.payments.index', compact('token', 'apartment', 'sponsorships'));
    }



    public function store(Request $request)
    {

        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $apartment = Apartment::findOrFail($request['apartment']);

        if ($apartment->user_id !== Auth::user()->id) {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }

        $id = $request["id"];
        $nonce = $request["payment_method_nonce"];

        $sponsorship = Sponsorship::findOrFail($id);





        $sponsorships = Sponsorship::all();
        $apartments = Apartment::all();

        $durations = $sponsorship->durations;
        $now = Carbon::now('Europe/Rome');
        $ending = Carbon::parse($now)->addHours($durations);

        $result = $gateway->transaction()->sale([
            'amount' => $sponsorship->price,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        //$oldTransactions = DB::table('apartment_sponsorship')->where('apartment_id', $request['apartment'])->where('sponsorship_id', $singleSponsorship->id)->get();

        $oldTransaction = DB::table('apartment_sponsorship')->where('apartment_id', $request['apartment'])->orderBy('ending_time', 'DESC')->first();
        /*  dd($oldTransaction); */


        if ($result->success) {
            if (isset($oldTransaction)) {
                $mutated = Carbon::parse($oldTransaction->ending_time);
                if ($mutated < $now) {
                    $sponsorship->apartments()->attach([$apartment->id => ['transaction_code' => $nonce, 'starting_time' => $now, 'ending_time' => $ending]]);
                    /* dd('é minore'); */
                } else {
                    $newEnding = Carbon::parse($mutated)->addHours($durations);
                    $sponsorship->apartments()->attach([$apartment->id => ['transaction_code' => $nonce, 'starting_time' => $mutated, 'ending_time' => $newEnding]]);
                    /* dd($oldTransaction);
                        dd('é maggiore'); */
                }
            } else {
                $sponsorship->apartments()->attach([$apartment->id => ['transaction_code' => $nonce, 'starting_time' => $now, 'ending_time' => $ending]]);
                /* dd('é la mia prima volta'); */
            }



            //dd($durations,  $now, $ending);

            $transaction = $result->transaction;

            return redirect()->route('registered.apartments.show', ['apartment' => $apartment])->with('sponsor-success-message', 'Transazione eseguita con successo');
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }

            return back()->withErrors('Error:' . $result->message);
        }
    }
}
