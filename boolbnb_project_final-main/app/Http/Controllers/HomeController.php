<?php

namespace App\Http\Controllers;

use App\Model\Apartment;
use App\Model\Sponsorship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$sponsoredApartments = [];

        $apartments = Apartment::where('user_id',  Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        return view('home', compact('apartments'));
    }
}
