<?php

namespace App\Http\Controllers\Admin;

use App\Accomodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRequest;
use App\SponsorPlan;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index(Accomodation $accomodation)
    {
        $sponsors = SponsorPlan::all();
        return view('admin.sponsors.index', compact('sponsors', 'accomodation'));
    }

    public function payment(Accomodation $accomodation, SponsorPlan $sponsor)
    {
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);
    
        $token = $gateway->ClientToken()->generate();
    
        return view('admin.sponsors.payment', compact('token','accomodation', 'sponsor'));
    }

    public function checkout(Request $request, Accomodation $accomodation, SponsorPlan $sponsor)
    {
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $data = $request->all();
        $amount = $data['amount'];
        $nonce = $data['payment_method_nonce'];

        $result = $gateway->transaction()->sale([
            'amount' =>  $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);


        if ($result->success) {

            $startDate = Carbon::now('Europe/Rome')->toDateTimeString();
            $endDate = Carbon::now('Europe/Rome')->addHours($sponsor->number_of_hours)->toDateTimeString();
            $accomodation->sponsor_plans()->sync([$sponsor->id => ['creating_date' => $startDate, 'expiring_date' => $endDate]]);

            return redirect()->route('admin.accomodations.show', $accomodation)->with('message', "L' annuncio '$accomodation->name' ora è tra gli alloggi in evidenza!");
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error:' . $error->code . ": " . $error->message . "\n";
            }

            return back()->withErrors('Si è verificato un errore. Leggi il messaggio:' . $result->message);
        }
    }

    private function getValidationRules()
    {
        // Auth::setlocale('it');

        return [
            'token' => 'required',
            'sponsor' => 'required',
        ];
    }
}
