<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DistanceController extends Controller
{
    public function coordinates(Request $request)
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

    public function distance(Request $request)
    {
        $data = $request->all();
        $accomodations = $data['params']['accomodations'];
        $coordinates = $data['params']['coordinates'];
        $distance = $data['params']['distance'];

        $filteredAccomodations = [];

        foreach ($accomodations as $accomodation) {
            $searchDistance = $this->getDistanceFromLatLonInKm($accomodation['latitude'], $accomodation['longitude'], $coordinates[0]['latitude'], $coordinates[0]['longitude']);
            if ($searchDistance <= $distance) {
                $filteredAccomodations[] = $accomodation;
            }
        }

        return response()->json([
            'success' => true,
            'results' => $filteredAccomodations,
        ]);
    }

    public function filteredDistance(Request $request)
    {
        $data = $request->all();
        $accomodations = $data['params']['accomodations'];
        $coordinates = $data['params']['coordinates'];
        $distance = $data['params']['distance'];
        $selectedBeds = $data['params']['selectedBeds'];
        $selectedRooms = $data['params']['selectedRooms'];
        $selectedFacilities = $data['params']['selectedFacilities'];


        $filteredAccomodations = [];

        foreach ($accomodations as $accomodation) {
            $searchDistance = $this->getDistanceFromLatLonInKm($accomodation['latitude'], $accomodation['longitude'], $coordinates[0]['latitude'], $coordinates[0]['longitude']);
            if ($searchDistance <= $distance) {
                $filteredAccomodations[] = $accomodation;
            }
            $newAccomodations = [];
            // No Filter
            if (
                $selectedBeds == null &&
                $selectedRooms == null &&
                count($selectedFacilities) == 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    $newAccomodations[] = $filteredAccomodation;
                }
                $filteredAccomodations = $newAccomodations;
            }
            // Beds
            else if (
                $selectedBeds != null &&
                $selectedRooms == null &&
                count($selectedFacilities) == 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    if (
                        $filteredAccomodation['n_beds'] == $selectedBeds
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Rooms
            else if (
                $selectedBeds == null &&
                $selectedRooms != null &&
                count($selectedFacilities) == 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    if (
                        $filteredAccomodation['n_rooms'] == $selectedRooms
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Facilities
            else if (
                $selectedBeds == null &&
                $selectedRooms == null &&
                count($selectedFacilities) != 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    $singleFacilityId = [];
                    $selectedFacilitiesIds = [];
                    $comparativeArray = [];
                    foreach ($filteredAccomodation['facilities'] as $facility) {
                        $singleFacilityId[] = $facility['id'];
                    };
                    foreach ($selectedFacilities as $id) {
                        $selectedFacilitiesIds[] = $id;
                    };
                    foreach ($selectedFacilitiesIds as $id) {
                        $comparativeArray[] = in_array($id, $singleFacilityId);
                    };
                    if (
                        !in_array(false, $comparativeArray)
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Beds + Rooms
            else if (
                $selectedBeds != null &&
                $selectedRooms != null &&
                count($selectedFacilities) == 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    if (
                        $filteredAccomodation['n_beds'] == $selectedBeds &&
                        $filteredAccomodation['n_rooms'] == $selectedRooms
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Beds + Rooms + Facilities
            else if (
                $selectedBeds != null &&
                $selectedRooms != null &&
                count($selectedFacilities) != 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    $singleFacilityId = [];
                    $selectedFacilitiesIds = [];
                    $comparativeArray = [];
                    foreach ($filteredAccomodation['facilities'] as $facility) {
                        $singleFacilityId[] = $facility['id'];
                    };
                    foreach ($selectedFacilities as $id) {
                        $selectedFacilitiesIds[] = $id;
                    };
                    foreach ($selectedFacilitiesIds as $id) {
                        $comparativeArray[] = in_array($id, $singleFacilityId);
                    };
                    if (
                        $filteredAccomodation['n_beds'] == $selectedBeds &&
                        $filteredAccomodation['n_rooms'] == $selectedRooms &&
                        !in_array(false, $comparativeArray)
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Beds + Facilities
            else if (
                $selectedBeds != null &&
                $selectedRooms == null &&
                count($selectedFacilities) != 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    $singleFacilityId = [];
                    $selectedFacilitiesIds = [];
                    $comparativeArray = [];
                    foreach ($filteredAccomodation['facilities'] as $facility) {
                        $singleFacilityId[] = $facility['id'];
                    };
                    foreach ($selectedFacilities as $id) {
                        $selectedFacilitiesIds[] = $id;
                    };
                    foreach ($selectedFacilitiesIds as $id) {
                        $comparativeArray[] = in_array($id, $singleFacilityId);
                    };
                    if (
                        $filteredAccomodation['n_beds'] == $selectedBeds &&
                        !in_array(false, $comparativeArray)
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
            // Rooms + Facilities
            else if (
                $selectedBeds == null &&
                $selectedRooms != null &&
                count($selectedFacilities) != 0
            ) {
                foreach ($filteredAccomodations as $filteredAccomodation) {
                    $singleFacilityId = [];
                    $selectedFacilitiesIds = [];
                    $comparativeArray = [];
                    foreach ($filteredAccomodation['facilities'] as $facility) {
                        $singleFacilityId[] = $facility['id'];
                    };
                    foreach ($selectedFacilities as $id) {
                        $selectedFacilitiesIds[] = $id;
                    };
                    foreach ($selectedFacilitiesIds as $id) {
                        $comparativeArray[] = in_array($id, $singleFacilityId);
                    };
                    if (
                        $filteredAccomodation['n_rooms'] == $selectedRooms &&
                        !in_array(false, $comparativeArray)
                    ) {
                        $newAccomodations[] = $filteredAccomodation;
                    }
                };
                $filteredAccomodations = $newAccomodations;
            }
        }

        return response()->json([
            'success' => true,
            'results' => $filteredAccomodations,
        ]);
    }

    private function getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius of the earth in km
        $dLat = $this->deg2rad($lat2 - $lat1);  // deg2rad below
        $dLon = $this->deg2rad($lon2 - $lon1);
        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos($this->deg2rad($lat1)) * cos($this->deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c; // Distance in km
        return $d;
    }

    private function deg2rad($deg)
    {
        return $deg * (pi() / 180);
    }
}
