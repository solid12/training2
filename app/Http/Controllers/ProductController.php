<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Product;


class ProductController extends Controller
{





    public function product(Request $request)
    {
        $title = '';
        $description = '';
        $price = '';
        $msg = '';

        if ($request->has('id')) {
            $id = $request->get('id');
            $x = Product::where('id', $id)->get();

            foreach ($products as $product) {
                $title = $product->title;
                $description = $product->description;
                $price = $product->price;
            }

        }
        if ($request->has('submit')) {
            $title = $request->get('title');
            $description = $request->get('description');
            $price = $request->get('price');

            $uploadOk = null;

            if ($request->has('fileToUpload')) {
                $fileName = $_FILES["fileToUpload"]["name"];
                $fileBaseName = substr($fileName, 0, strripos($fileName, '.'));
                $file_ext = substr($fileName, strripos($fileName, '.'));
                if ($request->has('id')) {
                    $idx = $request->get('id');
                } else {
                    $adm = session()->get('admin');
                    $idx = md5(date('Y/m/d') + $adm);
                }
                $newFileName = $idx . $file_ext;

                $target_dir = "images/";
                $target_file = $target_dir . $newFileName;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if ($request->has('submit')) {
                    @$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        $msg = "" . __('The file is a image') . " - " . $check["mime"] . ".";
                        $uploadOk = true;
                    } else {
                        $msg = __('The file not is image');
                        $uploadOk = false;
                    }
                }

                if (file_exists($target_file)) {
                    $msg = __('The file already exist !');
                    $uploadOk = false;
                } else {
                    $uploadOk = true;
                }

                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $msg = __('The file is large. Max. 50MB');
                    $uploadOk = false;
                } else {
                    $uploadOk = true;
                }

                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $msg = __('The format not is correct !');
                    $uploadOk = false;
                } else {
                    $uploadOk = true;
                }
            }

            if (!$request->has('id')) {

                if (!$title) {

                    $msg = __('Title not is set !');

                } else if (!$description) {

                    $msg = __('Description not is set !');

                } else if (!$price) {

                    $msg = __('Price not is set !');

                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $query = Product::insertGetId(['title' => $title, 'description' => $description, 'price' => $price]);
                        $idxx = "images/" . $query;
                        $adm = session()->get('admin');
                        $idx2 = "" . md5(date('Y/m/d') + $adm);
                        $files = Product::getImage($idx2);
                        rename("$files[0]", "$idxx.png");
                        $msg = __('The product is added !');
                    } else {
                        $msg = __('Error Upload');
                    }
                }
            } else {
                if ($uploadOk === false) {

                    $msg = __('Data not is submitted');

                } else if (!$title) {

                    $msg = __('Title not is set');

                } else if (!$description) {

                    $msg = __('Description not is set');

                } else if (!$price) {

                    $msg = __('Price not is set');

                } else {
                    if ($uploadOk === true) {
                        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $uploadOk = false;
                            $msg = __('Error Upload');
                        }
                    }

                    if ($uploadOk === true || $uploadOk === null) {
                        $id = $request->get('id');
                        Product::where('id', $id)->update(['title' => $title, 'description' => $description, 'price' => $price]);
                        $msg = __('The product is updated');
                        return redirect('/products');

                    }
                }
            }

        }

        return view('product', compact('msg', 'title', 'description', 'price'));

    }


    public function products()
    {

        $products = Product::get();
        foreach ($products as $product) {
            $images = Product::getImage($product->id);
        }
        $products = Product::orderBy('id', 'ASC')->get();

        return view('products', compact('products', 'images'));
    }

    public function delete(Request $request)
    {
        
        if ($request->has('id')) {
            $id = $request->get('id');
            Product::where('id', $id)->delete();
        }

        return view('delete');

    }
}
