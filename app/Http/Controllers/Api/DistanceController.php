<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DistanceController extends Controller
{
    public function distance(Request $request)
    {
        $data = $request->all();
        $query = $data['params']['query'];
        $distance = Http::get('https://api.tomtom.com/search/2/search/.json?key=d2mmEc8fneKRADNTRvtPyRb90pGg1OV6&query=' . $query);

        $location = [];
        $location[] = [
            'latitude' => $distance['results'][0]['position']['lat'],
            'longitude' => $distance['results'][0]['position']['lon']
        ];

        return response()->json([
            'success' => true,
            'results' => $location,
        ]);
    }
}
