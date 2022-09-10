<?php

namespace App\Http\Controllers\Api;

use App\Accomodation;
use App\AccomodationSponsored;
use App\Facility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccomodationController extends Controller
{
    public function index()
    {
        $accomodations = Accomodation::with('facilities')->where('is_visible', 1)->get();
        $facilities = Facility::all();
        foreach ($accomodations as $accomodation) {
            if ($accomodation->image) {
                $accomodation->image = url('storage/' . $accomodation->image);
            }
        }

        return response()->json([
            'success' => true,
            'appResults' => $accomodations,
            'facResults' => $facilities
        ]);
    }

    public function show($slug)
    {
        $accomodation = Accomodation::where('slug', '=', $slug)->with('facilities')->first();
        if ($accomodation) {
            if ($accomodation->image) {
                $accomodation->image = asset('storage/' . $accomodation->image);
            }
            return response()->json([
                'success' => true,
                'results' => $accomodation
            ]);
        }
        return response()->json([
            'success' => false,
            'error' => 'No Accomodation Found'
        ]);
    }

    public function sponsoredAccomodations()
    {
        $sponsoredAccomodations = AccomodationSponsored::all();
        $current_date = date("Y-m-d H:i:s");
        $accomodations = [];

        foreach ($sponsoredAccomodations as $item) {
            if ($item->end_promotion >= $current_date) {
                $accomodations[] = Accomodation::where('id', $item->accomodation_id)->where('visible', 1)->first();
            }
        }

        return response()->json([
            'success' => true,
            'results' => $accomodations
        ]);
    }
}
