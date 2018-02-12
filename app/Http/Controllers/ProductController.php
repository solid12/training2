<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Cart;


class ProductController extends Controller
{


    public function product(Request $request)
    {
        $title = '';
        $description = '';
        $price = '';
        $msg = '';

        if ($request->has('id')) 
        {
            $id = $request->get('id');
            $x = Cart::where('id', $id)->get();

            foreach ($x as $y) 
            {
                $title = $y->title;
                $description = $y->description;
                $price = $y->price;
            }

            if ($request->has('submit')) {
                $uploadOk = false;

                $title = $request->get('title');
                $description = $request->get('description');
                $price = $request->get('price');


                if ($uploadOk === false) {

                    $msg = __('Data not submited');

                } else if (!isset($title) && (!$title)) {

                    $msg = __('Title not set');

                } else if (!isset($description) && (!$description)) {

                    $msg = __('Description not set');

                } else if (!isset($price)) {

                    $msg = __('Price not set');

                } else {
                    if ($uploadOk === true) {

                        $fileBaseName = $request->file('fileToUpload')->path();
                        $file_ext = $request->file('fileToUpload')->extension();
                        $idx = $request->get('id');
                        $newFileName = $idx . $file_ext;
                        $target_file = $newFileName;

                        if (!(move('images/', $target_file))) {
                            $uploadOk = false;
                            $msg = __('Erorr upload');
                        }
                    }

                    if ($uploadOk === true || $uploadOk === null) {


                        Cart::where('id', $id)->update(['title' => $title, 'description' => $description, 'price' => $price]);

                        return redirect('/products');

                    }
                }

            }

        } else {

            if($request->has('submit')) {


                $title = $request->get('title');
                $description = $request->get('description');
                $price = $request->get('price');
                $uploadOk = false;

                if ($request->hasFile('fileToUpload')) {

                    $fileBaseName = $request->file('fileToUpload')->path();
                    $file_ext = $request->file('fileToUpload')->extension();

                    $adm = session()->get('admin');
                    $idx = md5(date('Y/m/d') + $adm);

                    $newFileName = $idx . $file_ext;
                    $target_file = $newFileName;


                    @$check = getimagesize($request->file('fileToUpload'));
                    if ($check !== false) {
                        $msg = "" . __('File is an image') . " - " . $check["mime"] . ".";
                        $uploadOk = true;
                    } else {
                        $msg = trans('file_not_img');
                        $uploadOk = false;
                    }


                    if (file_exists("images/" . $target_file)) {
                        $msg = __('The file already exist');
                        $uploadOk = false;
                    } else {
                        $uploadOk = true;
                    }

                    if ($request->file('fileToUpload')->getClientSize() > 500000) {
                        $msg = __('The file is large');
                        $uploadOk = false;
                    } else {
                        $uploadOk = true;
                    }

                    if ($file_ext != "jpg" && $file_ext != "png" && $file_ext != "jpeg" && $file_ext != "gif") {
                        $msg = __('The format is incorrect');
                        $uploadOk = false;
                    } else {
                        $uploadOk = true;
                    }


                    if (!$title) {

                        $msg = __('Title not set');

                    } else if (!$description) {

                        $msg = __('Description not set');

                    } else if (!$price) {

                        $msg = __('Price not set');

                    } else {

                        if (move('images/', $target_file)) {
                            Cart::insert(['title' => $title, 'description' => $description, 'price' => $price]);
                            $ix = Cart::getPdo()->lastInsertId();
                            $adm = session()->get('admin');
                            $idxx = "images/" . $ix . "";
                            $idx2 = "" . md5(date('Y/m/d') + $adm);
                            $files = glob("images/" . $idx2 . ".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE);
                            rename("$files[0]", "$idxx.png");
                            $msg = __('Product added');
                            return redirect('/products');
                        } else {
                            $msg = __('Error Upload');
                        }
                    }

                }
            }
        }

        return view('product', compact('msg', 'title', 'description', 'price'));

    }


    public function delete(Request $request)
    {

        if ($request->has('id')) {
            $id = $request->get('id');
            Cart::where('id', $id)->delete();

        }

        return view('delete');

    }
}
