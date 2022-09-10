<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $accomodations = Accomodation::all()->where('user_id', Auth::user()->id);
        $messages = Message::all()->where('user_id', Auth::user()->id);
        return view('admin.messages.index', compact('messages', 'accomodations'));
    }
}
