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
        /** @var \Illuminate\Http\Request $request */
        if ($request->has('id')) {
            session()->push('cart', $request->get('id'));
        }

        if (!session()->has('cart')) {
            $products = Product::get();
        } else {
            $products = Product::whereNotIn('id', session()->get('cart'))->get();
        }

        return view('index', compact('products'));
    }

    public function cart(Request $request)
    {
        if (!session()->has('cart') || !count(session()->get('cart'))) {
            return redirect('/');
        }

        $cart = session()->get('cart', []);

        if (($idx = $request->has('id')) && is_numeric($idx = $request->get('id'))) {
            if (($key = array_search($idx, $cart)) !== false) {
                unset($cart[$key]);
            }

            session()->put('cart', $cart);

            if (!count($cart)) {
                return redirect('/');
            }
        }

        if ($request->has('send')) {
            $products = Product::whereIn('id', $cart)->get();
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
            $data = [
                'products' => $products,
                'protocol' => $protocol,
                'name' => $request->input('name'),
                'contact' => $request->input('contact'),
                'comment' => $request->input('comment'),
            ];

            Mail::send('email.cart', $data, function ($message) {
                $message->from(config('app.sender'));
                $message->to(config('app.receiver'));
                $message->subject(__('Your Cart'));
            });

            session()->put('cart', []);

            return redirect('/');
        }

        $products = Product::whereIn('id', $cart)->get();
        foreach ($products as $product) {
            $images = getImage($product->id);
        }

        return view('cart', compact('products', 'images'));
    }

}
