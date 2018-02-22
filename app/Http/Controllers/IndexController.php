<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use App\Product;
use Mail;

class IndexController extends Controller
{

    public function index(Request $request)
    {

        if (!session()->has('cart')) {

            $products = Product::get();
            foreach($products as $product) {
                $images = Product::getImage($product->id);
            }

            if ($request->has('id')) {
                session()->push('cart', $request->get('id'));
            }

        } else {

            /** @var \Illuminate\Http\Request $request */
            if ($request->has('id')) {
                session()->push('cart', $request->get('id'));
            }
            $cartid = session()->get('cart');
            $products = Product::whereNotIn('id', $cartid)->get();
            foreach($products as $product) {
                $images = Product::getImage($product->id);
            }
        }



        return view('welcome', compact('products', 'images'));
    }

    public function cart(Request $request)
    {
        $cartid = session()->get('cart');

        if (!session()->has('cart')) {

            return redirect('/');

        }else{

        if ($request->has('id')) {
            $idx = $request->get('id');
            $products = session()->get('cart', []);

            if (($key = array_search($idx, $products)) !== false) {
                unset($products[$key]);
            }

        }

        if ($request->has('send')) {
            $products = Product::whereIn('id', $cartid)->get();
            foreach($products as $product) {
                $images = Product::getImage($product->id);
            }
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
            $data = [
                'product' => $product,
                'images' => $images,
                'protocol' => $protocol
            ];

            Mail::send('email.cart', $data, function ($message) {
                $message->from('sender@domain.com', 'Laravel Training');
                $message->to('receiver@domain.com');
                $message->subject('Your Cart');
            });

        }

        }
        $products = Product::whereIn('id', $cartid)->get();
        foreach($products as $product) {
            $images = Product::getImage($product->id);
        }

        return view('cart', compact('products', 'images'));
    }


}
