<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentGatewayController extends Controller
{
    function charge()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.tap.company/v2/authorize/', [
            'amount' => 1,
            'currency' => 'KWD',
            'customer_initiated' => true,
            'threeDSecure' => true,
            'save_card' => false,
            'statement_descriptor' => 'sample',
            'metadata' => [
                'udf1' => 'test_data_1',
                'udf2' => 'test_data_2',
                'udf3' => 'test_data_3',
            ],
            'reference' => [
                'transaction' => 'txn_0001',
                'order' => 'ord_0001',
            ],
            'receipt' => [
                'email' => true,
                'sms' => true,
            ],
            'customer' => [
                'first_name' => 'Test',
                'middle_name' => 'Test',
                'last_name' => 'Test',
                'email' => 'test@test.com',
                'phone' => [
                    'country_code' => '965',
                    'number' => '50000000',
                ],
            ],
            'merchant' => [
                'id' => '1234',
            ],
            'source' => [
                'id' => request('mytoken'),
            ],
            'authorize_debit' => false,
            'auto' => [
                'type' => 'VOID',
                'time' => 100,
            ],
            'post' => [
                'url' => '/',
            ],
            'redirect' => [
                'url' => route('charge-process'),
            ],
        ]);

        $responseData = $response->json();

        return redirect($responseData['transaction']['url']);
    }

    function chargeprocess()
    {
        $tapId = request('tap_id');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ',
            'accept' => 'application/json',
        ])->get("https://api.tap.company/v2/authorize/{$tapId}");

        $responseData = $response->json(); // information about transaction



        // I have saved the following static data.
        $data = Http::withHeaders([
            'Authorization' => 'Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.tap.company/v2/charges/', [
            'amount' => 1,
            'currency' => 'KWD',
            'customer_initiated' => true,
            'threeDSecure' => true,
            'save_card' => false,
            'description' => 'Test Description',
            'metadata' => [
                'udf1' => 'Metadata 1',
            ],
            'reference' => [
                'transaction' => 'txn_01',
                'order' => 'ord_01',
            ],
            'receipt' => [
                'email' => true,
                'sms' => true,
            ],
            'customer' => [
                'first_name' => 'test',
                'middle_name' => 'test',
                'last_name' => 'test',
                'email' => 'test@test.com',
                'phone' => [
                    'country_code' => 965,
                    'number' => 51234567,
                ],
            ],
            'merchant' => [
                'id' => '1234',
            ],
            'source' => [
                'id' => request('tap_id'),
            ],
            'post' => [
                'url' => 'http://your_website.com/post_url',
            ],
            'redirect' => [
                'url' => 'http://your_website.com/redirect_url',
            ],
        ]);

        dd($data->json());
    }
}
