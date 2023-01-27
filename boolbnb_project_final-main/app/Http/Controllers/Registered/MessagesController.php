<?php

namespace App\Http\Controllers\Registered;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\Message;
use App\Model\Apartment;
use App\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Message $message)
    {
        // In futuro si può implementare un'utenza admin
        /* $apartments = Apartment::where('user_id', Auth::user()->id)->get();
        $arrayOfMessages = [];

        foreach ($apartments as $apartment) {
            $apartmentMessages = Message::where('apartment_id', $apartment->id)->get();
            array_push($arrayOfMessages, $apartmentMessages);
        }
        return view(
            'registered.messages.index',
            ['apartments' => $apartments, 'arrayOfMessages' => $arrayOfMessages]
        ); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function show($id)
    {
        $user = Auth::user()->id;
        $apartment = Apartment::findOrFail($id);
        if ($apartment->user_id == $user) {
            return view('registered.messages.show', ['apartment' => $apartment]);
        } else {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }
    } */
    public function show($id)
    {
        $user = Auth::user()->id;
        $apartment = Apartment::findOrFail($id);
        $messages = Message::where('apartment_id', $apartment->id)->orderBy('created_at', 'DESC')->get();
        if ($apartment->user_id == $user) {
            return view('registered.messages.show', ['apartment' => $apartment, 'messages' => $messages]);
        } else {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
