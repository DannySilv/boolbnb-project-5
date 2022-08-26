<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Facility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AccomodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accomodations = Accomodation::all();
        return view('admin.accomodations.index', compact('accomodations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facilities = Facility::all();
        return view('admin.accomodations.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        $data = $request->all();

        if (isset($data['image'])) {
            $image = Storage::put('image', $data['image']);
            $data['image'] = $image;
        }

        $local = Http::get('https://api.tomtom.com/search/2/search/.json?key=tK1dfG1bbj4Bwrg4EHPfImXRSLMFlytw&query=' . $data['address']);
        $data['longitude'] = $local['results']['0']['position']['lon'];
        $data['latitude'] = $local['results']['0']['position']['lat'];

        $new_accomodation = new Accomodation();
        $new_accomodation->fill($data);
        $new_accomodation->slug = Accomodation::generatePostSlug($new_accomodation->name);
        $new_accomodation->save();

        if (isset($data['facilities'])) {
            // tramite la funzione sync andiamo a riscrivere l'array dei facilities
            $new_accomodation->facilities()->sync($data['facilities']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $current_accomodation = Accomodation::findOrFail($id);
        $facilities = Facility::all();
        // dd($current_accomodation);

        return view('admin.accomodations.show', compact('current_accomodation', 'facilities'));
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
        // $current_accomodation = Accomodation::findOrFail($id);
        // if ($current_accomodation->image) {
        //     Storage::delete($current_accomodation->image);
        // }
        // $current_accomodation->delete();

        // return redirect()->route('admin.posts.index');
    }

    private function getValidationRules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:30000',
            'n_rooms' => 'required|numeric|min:1|max:99',
            'n_beds' => 'required|numeric|min:1|max:99',
            'n_bathrooms' => 'required|numeric|min:1|max:99',
            'size_sqm' => 'required|numeric|min:1|max:500',
            'address' => 'required|min:3|max:255',
            'facilities' => 'nullable|exists:facilities,id',
            'image' => 'image|max:1024'
        ];
    }
}
