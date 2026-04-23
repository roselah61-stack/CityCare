<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    //


public function checkout()
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Test Product',
                ],
                'unit_amount' => 1000, // $10
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => url('/success'),
        'cancel_url' => url('/cancel'),
    ]);

    return redirect($session->url);
}
}
