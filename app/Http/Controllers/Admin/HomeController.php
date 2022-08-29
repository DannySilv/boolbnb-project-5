<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index () 
    {
        $user = Auth::user();
        $accomodations = Accomodation::all();
        return view('admin.home', compact('user', 'accomodations'));
    }
}
