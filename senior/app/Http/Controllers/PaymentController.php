<?php

namespace App\Http\Controllers;


use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Request $request)
    {

        $request->validate([
            'subscribe' => 'required|string',
            'card_number' => 'required|string|size:16',
            'yy_mm' => 'required|integer|min:2023',
            'plan' => 'required|string'
        ]);

        return response()->json(['success' => true, 'message' => 'Payment successful!']);
    }
}
