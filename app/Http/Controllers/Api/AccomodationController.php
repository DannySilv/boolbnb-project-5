<?php

namespace App\Http\Controllers\Api;

use App\Accomodation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccomodationController extends Controller
{
    public function index()
    {
        $accomodations = Accomodation::paginate(6);
        foreach ($accomodations as $accomodation) {
            if ($accomodation->image) {
                $accomodation->image = url('storage/' . $accomodation->image);
            }
        }

        return response()->json([
            'success' => true,
            'results' => $accomodations
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
}
