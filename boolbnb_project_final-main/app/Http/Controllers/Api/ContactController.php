<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Send an email from the website form.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // # Validazione
        $validator = Validator::make(
            $data,
            [
                'apartment_id' => 'required',
                'guest_name' => 'required',
                'guest_email' => 'required|email',
                'content' => 'required'
            ],
            [
                'guest_name.required' => 'Il nome è obbligatorio [da Laravel].',
                'guest_email.required' => 'La mail è obbligatoria [da Laravel].',
                'guest_email.email' => 'L\'indirizzo email non è valido [da Laravel].',
                'content.required' => 'Il testo del messaggio è obbligatorio [da Laravel].'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        };

        // ? Creo un'istanza di Message
        $newMessage = new Message();
        // ? Inserisco i dati nel DB
        $newMessage->fill($data);
        // ? Salvo le modifiche
        $newMessage->save();

        return response('Email inviata con successo', 204); // o return response('Mail received', 201)
    }
}
