<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Facility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class AccomodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accomodations = Accomodation::all()->where('user_id', Auth::user()->id);
        // $accomodations = Accomodation::paginate(6);
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

        $data['user_id'] = Auth::user()->id;

        // Chiamata con metodo GET all'API di tom tom, ci serve per prelevare da una Città la corrispondente lat e long
        $local = Http::get('https://api.tomtom.com/search/2/search/.json?key=tK1dfG1bbj4Bwrg4EHPfImXRSLMFlytw&query=' . $data['address']);
        $data['longitude'] = $local['results']['0']['position']['lon'];
        $data['latitude'] = $local['results']['0']['position']['lat'];

        $new_accomodation = new Accomodation();
        $new_accomodation->fill($data);
        $new_accomodation->slug = Accomodation::generateAccomodationSlug($new_accomodation->name);
        $new_accomodation->is_visible = $data['visibility'] == 'true' ? 1 : 0;
        $new_accomodation->save();

        if (isset($data['facilities'])) {
            // tramite la funzione sync andiamo a riscrivere l'array dei facilities
            $new_accomodation->facilities()->sync($data['facilities']);
        }

        return redirect()->route('admin.accomodations.show', ['accomodation' => $new_accomodation->id]);
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
        $user_id = Auth::id();
        $facilities = Facility::all();

        return view('admin.accomodations.show', compact('current_accomodation', 'facilities', 'user_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_accomodation = Accomodation::findOrFail($id);
        $user_id = Auth::id();
        $facilities = Facility::all();
        return view('admin.accomodations.edit', compact('current_accomodation', 'facilities', 'user_id'));
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
        $request->validate($this->getValidationRules());

        $data = $request->all();

        $current_accomodation = Accomodation::findOrFail($id);

        // Chiamata con metodo GET all'API di tom tom, ci serve per prelevare da una Città la corrispondente lat e long
        $local = Http::get('https://api.tomtom.com/search/2/search/.json?key=tK1dfG1bbj4Bwrg4EHPfImXRSLMFlytw&query=' . $data['address']);
        $data['longitude'] = $local['results']['0']['position']['lon'];
        $data['latitude'] = $local['results']['0']['position']['lat'];

        // Se l'utente modifica l'immagine
        if (isset($data['image'])) {
            // se l'immagine effettivamente è diversa dalla precedente
            if ($current_accomodation->image) {
                // Elimina l'immagine precedente
                Storage::delete($current_accomodation->image);
            }

            // Salva la nuova immagine
            $image = Storage::put('image', $data['image']);
            $data['image'] = $image;
        }

        $current_accomodation->fill($data);
        $current_accomodation->slug = Accomodation::generateAccomodationSlug($current_accomodation->name);
        $current_accomodation->is_visible = $data['visibility'] == 'true' ? 1 : 0;
        $current_accomodation->save();

        // Se la variabile $data con attributo ['facilities'] è stata dichiarata ed è diversa da null
        if (isset($data['facilities'])) {
            // tramite la funzione sync andiamo a riscrivere l'array dei facilities
            $current_accomodation->facilities()->sync($data['facilities']);
        }

        return redirect()->route('admin.accomodations.show', ['accomodation' => $current_accomodation->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_accomodation = Accomodation::findOrFail($id);

        //Per eliminare l'immagine dalla cartella storage
        if ($current_accomodation->image) {
            Storage::delete($current_accomodation->image);
        }

        $current_accomodation->delete();

        return redirect()->route('admin.accomodations.index');
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
            'facilities' => 'required|exists:facilities,id',
            'image' => 'image|max:1024'
        ];
    }
}
