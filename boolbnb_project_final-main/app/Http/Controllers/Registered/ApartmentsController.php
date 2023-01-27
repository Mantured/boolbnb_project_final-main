<?php

namespace App\Http\Controllers\Registered;

use App\Http\Controllers\Controller;
use App\Model\Apartment;
use App\Model\Apartment_image;
use App\Model\Message;
use App\Model\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*  public function index()
    {

        $apartments = Apartment::where('user_id',  Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        $arrayOfMessages = [];

        foreach ($apartments as $apartment) {
            $apartmentMessages = Message::where('apartment_id', $apartment->id)->get();
            array_push($arrayOfMessages, $apartmentMessages);
        }
        return view('registered.apartment.index', ['apartments' => $apartments, 'apartmentMessages' => $apartmentMessages]);
    } */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return view('registered.apartment.create', ['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:100',
                'description' => 'required|min:10',
                'beds_number' => 'numeric|min:1|max:20',
                'rooms_number' => 'numeric|min:1|max:20',
                'bathrooms_number' => 'numeric|min:1|max:20',
                'square_meters' => 'required|numeric|min:20|max:200',
                'price_per_night' => 'required|numeric|max:99999',
                'address' => 'required',
                'image_path' => 'required',
                /* 'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', */

            ],
            [
                'required' => ':attribute è richiesto',
                'numeric' => ':attribute deve essere un numero',
                'min' => 'Per :attribute il minimo è :min',
                'max' => 'Per :attribute il massimo è :max',
            ]
        );

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $randomInt = rand(1, 100);
        $data['slug'] = Str::slug($data['title'], "-") . "-" . ($randomInt);
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->save();

        // Se esiste almeno un servizio
        if (isset($data['service'])) {
            $apartment->services()->attach($data['service']);
        }

        // Se esistono immagini
        if ($request->hasfile('image_path')) {
            // Ciclo per tutte le immagini
            foreach ($request->file('image_path') as $image) {
                // Mi creo il nome del nuovo file, iniziante con un numero randomico e sostituendo gli spazi
                $imageName = rand(0, 10000) . '_' . str_replace(" ", "_", $image->getClientOriginalName());

                // Faccio l'upload dell'immagine
                $image->storeAs('uploads', $imageName, 'public');

                // Creo una nuova Istanza del Model Image
                $newImage = new Apartment_image();
                $newImage->apartment_id = $apartment->id;
                $newImage->image_path = 'uploads/' . $imageName;
                $newImage->save();
            }
        }


        return redirect()->route('registered.apartments.show', ['apartment' => $apartment]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        if ($apartment->user_id == Auth::user()->id) {
            return view('registered.apartment.show', ['apartment' => $apartment]);
        } else {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        if ($apartment->user_id == Auth::user()->id) {
            return view('registered.apartment.edit', [
                'apartment' => $apartment,
                'services' => $services
            ]);
        } else {
            return redirect()->route('home')->with('error-message', 'Accesso non consentito');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate(
            [
                'title' => 'required|max:100',
                'description' => 'required|min:10',
                'beds_number' => 'numeric|min:1|max:20',
                'rooms_number' => 'numeric|min:1|max:20',
                'bathrooms_number' => 'numeric|min:1|max:20',
                'square_meters' => 'required|numeric|min:20|max:200',
                'price_per_night' => 'required|numeric|max:99999',
                'address' => 'required',
                // 'image_path' => 'required',
                /* 'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', */
            ],
            [
                'required' => ':attribute è richiesto',
                'numeric' => ':attribute deve essere un numero',
                'min' => 'Per :attribute il minimo è :min',
                'max' => 'Per :attribute il massimo è :max',
            ]
        );

        $data = $request->all();
        //dd($data);

        // Se ci sono vecchie immagini da mantenere
        if (isset($data['old_images'])) {
            // Le memorizzo in un'array
            $updatedImages = $data['old_images'];
        } else {
            // Altrimenti inizzializzo un'array vuoto
            $updatedImages = [];
        }

        $randomInt = rand(1, 100);
        $data['slug'] = Str::slug($data['title'], "-") . "-" . ($randomInt);
        $apartment->fill($data);
        $apartment->save();

        // Se esiste almeno un servizio
        if (isset($data['service'])) {
            // Aggiungo i servizi nella tabella ponte
            $apartment->services()->sync($data['service']);
        }

        // Se esistono immagini
        if ($request->hasfile('image')) {
            // Ciclo per tutte le immagini
            foreach ($request->file('image') as $image) {
                // Mi creo il nome del nuovo file, iniziante con un numero randomico e sostituendo gli spazi
                $imageName = rand(0, 10000) . '_' . str_replace(" ", "_", $image->getClientOriginalName());

                // Faccio l'upload dell'immagine
                $image->storeAs('uploads', $imageName, 'public');

                // Creo una nuova Istanza del Model Image
                $newImage = new Apartment_image();
                $newImage->apartment_id = $apartment->id;
                $newImage->image_path = 'uploads/' . $imageName;
                $newImage->save();
                // ? Aggiungo l'immagine appena salvata nel DB alla collezzione delle vecchie immagini
                array_push($updatedImages, $newImage->image_path);
            }
        }

        // ? Prendo tutte le immagini per l'appartamento corrente
        $related_apt_images = Apartment_image::where('apartment_id', 'LIKE', $apartment->id)->pluck('image_path')->toArray();
        //dd(array_diff($related_apt_images, $updatedImages), $related_apt_images, $updatedImages);

        // Array che contiene le immagini da rimuovere
        $imagesToRemove = array_diff($related_apt_images, $updatedImages);
        foreach ($imagesToRemove as $image) {
            // Rimuovo l'immagine dallo storage
            Storage::disk('public')->delete($image);
            // Se l'mmagine da rimuovere è presente nel db, la rimuovo
            Apartment_image::where('image_path', $image)->firstOrFail()->delete();
        }


        return redirect()->route('registered.apartments.show', ['apartment' => $apartment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('home')->with('deleted-message', "$apartment->title é stato delittato correttamente");
    }
}
