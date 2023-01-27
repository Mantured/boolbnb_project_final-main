<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Apartment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Model\Sponsorship;

class ApartmentController extends Controller
{

    /**
     * serarch
     *
     * @param  mixed $string
     * @return void
     */
    public function search($lat, $lon, $km)
    {
        $minLat = round($lat - ((1 / 111) * $km), 5);
        $minLon = round($lon - ((1 / 85) * $km), 5);
        $maxLat = round($lat + ((1 / 111) * $km), 5);
        $maxLon = round($lon + ((1 / 85) * $km), 5);



        $apartments = Apartment::with(['services', 'apartment_images'])->whereBetween('latitude', [$minLat, $maxLat])->whereBetween('longitude', [$minLon, $maxLon])->where('is_visible', 1)->get();
        return response()->json(
            [
                'results' => $apartments,
            ]
        );
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $lat = $data['lat'];
        $lon = $data['lon'];
        $km = $data['radius'];
        if (isset($data['rooms_number'])) {
            $rooms_number = $data['rooms_number'];
        } else {
            $rooms_number = 1;
        }
        if (isset($data['beds_number'])) {
            $beds_number = $data['beds_number'];
        } else {
            $beds_number = 1;
        }
        if (isset($data['services'])) {
            $services = explode(',', $data['services']);
        } else {
            $services = [];
        }


        $minLat = round($lat - ((1 / 111) * $km), 5);
        $minLon = round($lon - ((1 / 85) * $km), 5);
        $maxLat = round($lat + ((1 / 111) * $km), 5);
        $maxLon = round($lon + ((1 / 85) * $km), 5);

        $result = Apartment::with(['services', 'apartment_images'])->whereBetween('latitude', [$minLat, $maxLat])->whereBetween('longitude', [$minLon, $maxLon])
            ->where('rooms_number', '>=', $rooms_number)
            ->where('beds_number', '>=', $beds_number)
            ->where('is_visible', 1)
            ->where(function ($query) use ($services) {
                foreach ($services as $service) {
                    $query->whereHas('services', function ($query) use ($service) {
                        $query->where('id', $service);
                    });
                }
            })
            ->get();

        return response()->json(
            [
                'results' => $result,
            ]
        );
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsored()
    {
        $sponsoredApartments = [];

        $apartments = Apartment::with(['services', 'sponsorships', 'messages', 'user', 'apartment_images'])->where('is_visible', 1)->inRandomOrder()->get();
        foreach ($apartments as $apartment) {
            $oldTransaction = DB::table('apartment_sponsorship')->where('apartment_id', $apartment->id)->orderBy('ending_time', 'DESC')->first();
            if(isset($oldTransaction)){
                $now = Carbon::now('Europe/Rome');
                $checkDate = Carbon::parse($oldTransaction->ending_time);
                if($checkDate > $now ){
                    array_push($sponsoredApartments, $apartment);
                }
            }
        }
        return response()->json($sponsoredApartments);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function random()
    {
        $randomApartments = [];
        $apartments = Apartment::with(['services', 'sponsorships', 'messages', 'user', 'apartment_images'])->where('is_visible', 1)->inRandomOrder()->get();

        foreach ($apartments as $apartment) {
            $oldTransaction = DB::table('apartment_sponsorship')->where('apartment_id', $apartment->id)->orderBy('ending_time', 'DESC')->first();
            if(isset($oldTransaction)){
                $now = Carbon::now('Europe/Rome');
                $checkDate = Carbon::parse($oldTransaction->ending_time);
                if($checkDate < $now ){
                    array_push($randomApartments, $apartment);
                }
            } else {
                array_push($randomApartments, $apartment);
            }
        }

        return response()->json($randomApartments);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::with(['services', 'sponsorships', 'messages', 'user', 'apartment_images'])->where('is_visible', 1)->paginate(15);
        return response()->json($apartments);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::with(['services', 'apartment_images'])->findOrFail($id);
        return response()->json([
            'results' =>  $apartment
        ]);
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
