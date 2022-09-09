<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all()->where('user_id', Auth::user()->id);
        $user_id = Auth::id();
        return view('admin.messages.index', compact('messages', 'user_id'));
    }
}
