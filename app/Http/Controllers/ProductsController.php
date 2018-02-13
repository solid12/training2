<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;

class ProductsController extends Controller
{
    public function index()
    {

        $prod = Cart::get();

        foreach ($prod as $prods) {
            $images = glob('images/' . $prods->id . '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
        }
        $products = Cart::orderBy('id', 'ASC')->get();

        return view('products', compact('products', 'images'));
    }



}
