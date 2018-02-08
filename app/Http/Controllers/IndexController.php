<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Cart;
use Mail;
use App\User;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        if (!session()->has('cart')) {
            $prod = Cart::all();

            foreach ($prod as $prods) {
                $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
            }
            if ($request->has('id')) {
                session()->push('cart', $request->get('id'));

                $cartid = session()->get('cart');
                $prod = Cart::whereNotIn('id', $cartid)->get();

                foreach ($prod as $prods) {
                    $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
                }
            }

        } else {

            /** @var \Illuminate\Http\Request $request */
            if ($request->has('id')) {
                session()->push('cart', $request->get('id'));

                $cartid = session()->get('cart');
                $prod = Cart::whereNotIn('id', $cartid)->get();

                foreach ($prod as $prods) {
                    $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
                }

            } else {
                $cartid = session()->get('cart');
                $prod = Cart::whereNotIn('id', $cartid)->get();

                foreach ($prod as $prods) {
                    $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
                }
            }
        }

        return view('welcome', compact('prod', 'images'));
    }

    public function cart(Request $request)
    {
        if ($request->has('id')) {

            $idx = $request->get('id');
            $products = session()->get('cart', []);

            if (($key = array_search($idx, $products)) !== false) {

                unset($products[$key]);
            }

            $cartid = session()->get('cart');
            $prod = Cart::whereIn('id', $cartid)->get();

            foreach ($prod as $prods) {
                $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
            }
        }

        if ($request->has('send')) {
            $cartid = session()->get('cart');

            $prod = Cart::whereIn('id', $cartid)->get();

            foreach ($prod as $prods) {
                $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
            }

            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';

            $data = [
                'prod' => $prod,
                'images' => $images,
                'protocol' => $protocol
            ];

            Mail::send('email.cart', $data, function ($message) {
                $message->from('sender@domain.com', 'Laravel Training');
                $message->to('receiver@domain.com');                
                $message->subject('Your Cart');
            });

        }

        $cartid = session()->get('cart');
        $prod = Cart::whereIn('id', $cartid)->get();

        foreach ($prod as $prods) {
            $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
        }

        return view('cart', compact('prod', 'images'));
    }


}
