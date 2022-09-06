<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        //1.Validazione
        $request->validate($this->getValidationRules());

        // Salviamo il messaggio in db
        $new_message = new Message();
        $new_message->fill($data);
        $new_message->save();

        return response()->json([
            'success' => true,
            'results' => "Done",
        ]);
    }

    private function getValidationRules()
    {
        return [
            'appartment_id' => 'required',
            'user_id' => 'required',
            'user_name' => 'required',
            'user_surname' => 'required',
            'email' => 'required',
            'message_text' => 'required',
        ];
    }
}
