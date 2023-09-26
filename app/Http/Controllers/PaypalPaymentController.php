<?php

namespace App\Http\Controllers;

use App\Order;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

use Illuminate\Http\Request;

class PaypalPaymentController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware("auth");
    // }

    public function handlePayment()
    {
        $provider = new ExpressCheckout;
        $data = [];
        $data['items'] = [];

        foreach (\Cart::getContent() as $item) {
            array_push($data['items'], [
                'name' => $item->name,
                'price' => (int) ($item->price / 9),
                'desc' => $item->associatedModel->description,
                'qty' => $item->quantity
            ]);
        }


        // $data['invoice_id'] = auth()->user()->id;
        $data['invoice_id'] = 1;
        // $data['invoice_description'] = "Commande #{$data['invoice_id']}";
        $data['invoice_description'] = "Item Payment";
        $data['return_url'] = url('/payment-success');
        $data['cancel_url'] = url('/cancel-payment');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
        $paypalModule = new ExpressCheckout;

        $res = $paypalModule->setExpressCheckout($data);
        $res = $paypalModule->setExpressCheckout($data, true);

        return redirect($res['paypal_link']);
    }

    public function paymentCancel()
    {
        return redirect('/cart')->with([
            'info' => 'Order canceled'
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $paypalModule = new ExpressCheckout;
        // $response = $paypalModule->getExpressCheckoutDetails($request->token);
        // if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            foreach (\Cart::getContent() as $item) {
                Order::create([
                    // "user_id" => auth()->user()->id,
                    "user_id" => 1,
                    "product_name" => $item->name,
                    "qty" => $item->quantity,
                    "price" => $item->price,
                    "total" => $item->price * $item->quantity,
                    "paid" => 1
                ]);
                \Cart::clear();
            }
            return redirect('/cart')->withSuccess('Paid successfully');


    }



    // public function handlePayment()
    // {
    //     $provider = new ExpressCheckout;

    //     $data = [];
        // $data['items'] = [
        //    [
        //       'name' => 'Product 1',
        //      'price' => 9.99,
        //      'desc'  => 'Description for product 1',
        //      'qty' => 1
        //    ],
        //    [
        //      'name' => 'Product 2',
        //      'price' => 4.99,
        //      'desc'  => 'Description for product 2',
        //      'qty' => 2
        //    ]

        // ];
    //     $data['items'] = [];

    //     foreach (\Cart::getContent() as $item) {
    //         array_push($data['items'], [
    //             'name' => $item->name,
    //             'price' => (int) ($item->price / 9),
    //             'desc' => $item->associatedModel->description,
    //             'qty' => $item->quantity
    //         ]);
    //     }

    //  $data['invoice_id'] = 1;
    //  $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
    //  $data['return_url'] = url('/payment/success');
    //  $data['cancel_url'] = url('/cart');

    //  $total = 0;
    //  foreach($data['items'] as $item) {
    //       $total += $item['price']*$item['qty'];
    //     }

    //  $data['total'] = $total;

    //  //give a discount of 10% of the order amount
    //  $data['shipping_discount'] = round((10 / 100) * $total, 2);

    //  //  SetExpressCheckout

    //    $response = $provider->setExpressCheckout($data);

    //  // Use the following line when creating recurring payment profiles (subscriptions)
    //   $response = $provider->setExpressCheckout($data, true);

    //  // This will redirect user to PayPal
    //  return redirect($response['paypal_link']);

    //  //  GetExpressCheckoutDetails

    //  $response = $provider->getExpressCheckoutDetails($token);
    // }


}

