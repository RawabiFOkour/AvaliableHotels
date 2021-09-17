<?php

namespace App\Http\Controllers;

use App\Models\AvailableHotel;
use Illuminate\Http\Request;

class AvailableHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $providers = [
            [
                'id' => 1,
                'name' => 'BestHotels',
            ],
            [
                'id' => 2,
                'name' => 'CrazyHotels',
            ]
        ];

        return view('hotels.available_hotels', ['providers' => $providers]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\AvailableHotel $availableHotel
     * @return \Illuminate\Http\Response
     */
    public function show(AvailableHotel $availableHotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\AvailableHotel $availableHotel
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailableHotel $availableHotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AvailableHotel $availableHotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvailableHotel $availableHotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\AvailableHotel $availableHotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvailableHotel $availableHotel)
    {
        //
    }

    // ajax request
    public function getAvailableHotels(Request $request)
    {

        $draw = $request->get('draw');
        $search_arr = $request->get('search');

        // general search
        $searchValue = $search_arr['value']; // Search value

        //get provider value for more scalability
        $provider = $request->get('provider');

        //query parameters from request
        $fromDate = $request->get('fromDate');
        $toDate = $request->get('toDate');
        $city = $request->get('city');
        $numberOfAdults = $request->get('numberOfAdults');

        // mock data rather than create database and models
        $availableHotels = [
            [
                'id' => 1,
                'hotelName' => 'Grand Hyatt Amman',
                'provider' => 'BestHotels',
                'fare' => '50.4344',
                'rate' => 3,
                'amenities' => ['Free Wi-Fi', 'Healthy Breakfast', 'Laundry Services']
            ],
            [
                'id' => 2,
                'hotelName' => 'W Amman Hotel',
                'provider' => 'CrazyHotels',
                'fare' => '40.4335',
                'rate' => 5,
                'amenities' => ['Free Wi-Fi', 'Laundry Services']
            ],
            [
                'id' => 3,
                'hotelName' => 'Land Mark Hotel',
                'provider' => 'BestHotels',
                'fare' => '30.1056',
                'rate' => 5,
                'amenities' => ['Free Wi-Fi', 'Healthy Breakfast']
            ],
            [
                'id' => 4,
                'hotelName' => 'for seasons Hotel',
                'provider' => 'BestHotels',
                'fare' => '30.1078',
                'rate' => 1,
                'amenities' => ['Free Wi-Fi', 'Healthy Breakfast']
            ],
        ];

        $availableHotelsFiltered = [];
        $bestHotels = [];
        $crazyHotels = [];
        $filterWithSearch = [];

        // when provider == BestHotels
        if ($provider == "BestHotels") {

            foreach ($availableHotels as $availableHotel) {
                if ($availableHotel['provider'] == "BestHotels") {
                    $availableHotelsFiltered [] = $availableHotel;
                }
            }

            foreach ($availableHotelsFiltered as $key => $hotelsFiltered) {

                $hotelsFiltered['id'] = $hotelsFiltered['id'];
                $hotelsFiltered['hotelName'] = $hotelsFiltered['hotelName'];
                $hotelsFiltered['provider'] = $hotelsFiltered['rate'];
                $hotelsFiltered['fare'] = round($hotelsFiltered['fare'], 2);
                $hotelsFiltered['amenities'] = implode(", ", $hotelsFiltered['amenities']);
                $bestHotels[$key] = $hotelsFiltered;

            }

            //when user search value
            if (!empty($searchValue)) {
                foreach ($bestHotels as $key => $bestHotel) {

                    if (str_contains($bestHotel['id'], $searchValue) || str_contains(strtolower($bestHotel['hotelName']), $searchValue)
                        || str_contains($bestHotel['provider'], $searchValue) || str_contains($bestHotel['fare'], $searchValue)
                        || str_contains(strtolower($bestHotel['amenities']), $searchValue)) {
                        $filterWithSearch[$key] = $bestHotel;
                    }
                }

            }

            $availableHotelsFiltered = (!empty($searchValue)) ? collect($filterWithSearch)->sortByDesc('provider')->values()->all() : collect($bestHotels)->sortByDesc('provider')->values()->all();

        }
        elseif ($provider == "CrazyHotels") {

            foreach ($availableHotels as $availableHotel) {
                if ($availableHotel['provider'] == "CrazyHotels") {
                    $availableHotelsFiltered [] = $availableHotel;
                }
            }

            foreach ($availableHotelsFiltered as $key => $hotelsFiltered) {

                $hotelsFiltered['id'] = $hotelsFiltered['id'];
                $hotelsFiltered['hotelName'] = $hotelsFiltered['hotelName'];
                $hotelsFiltered['provider'] = $hotelsFiltered['rate'];
                $hotelsFiltered['fare'] = round($hotelsFiltered['fare'], 2);
                $hotelsFiltered['amenities'] = implode(", ", $hotelsFiltered['amenities']);
                $crazyHotels[$key] = $hotelsFiltered;

            }


            if (!empty($searchValue)) {
                foreach ($crazyHotels as $key => $crazyHotel) {

                    if (str_contains($crazyHotel['id'], $searchValue) || str_contains(strtolower($crazyHotel['hotelName']), $searchValue)
                        || str_contains($crazyHotel['provider'], $searchValue) || str_contains($crazyHotel['fare'], $searchValue)
                        || str_contains(strtolower($crazyHotel['amenities']), $searchValue)) {
                        $filterWithSearch[$key] = $crazyHotel;
                    }
                }

            }
            $availableHotelsFiltered = (!empty($searchValue)) ? collect($filterWithSearch)->sortByDesc('provider')->values()->all() : collect($crazyHotels)->sortByDesc('provider')->values()->all();

        }
        elseif($provider == "HotelsForAllProviders") {


            if (!empty($searchValue)) {
                foreach ($availableHotels as $key => $availableHotel) {

                    if (str_contains($availableHotel['id'], $searchValue) || str_contains(strtolower($availableHotel['hotelName']), $searchValue)
                        || str_contains(strtolower($availableHotel['provider']), $searchValue) || str_contains($availableHotel['fare'], $searchValue)
                        ||  str_contains( strtolower(implode(", ",$availableHotel['amenities'])),$searchValue)
                    ) {
                        $filterWithSearch[$key] = $availableHotel;
                    }
                }

            }

            $availableHotelsFiltered = (!empty($searchValue)) ? collect($filterWithSearch)->sortByDesc('id')->values()->all()  :  collect($availableHotels)->sortByDesc('id')->values()->all() ;
        }


        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => collect($availableHotels)->count(),
            "recordsFiltered" => collect($availableHotelsFiltered)->count(),
            "data" => $availableHotelsFiltered,
        ]);
    }
}
