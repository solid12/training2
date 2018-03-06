<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;


class ProductController extends Controller
{
    public function checkLogin()
    {
        if (!session('admin')) {
            throw new \Exception('Unauthorized');
        }
    }

    public function product(Request $request)
    {
        $this->checkLogin();

        $msg = '';
        $idx = $request->get('id');

        $product = new Product();
        if ($request->has('id')) {
            $id = $request->get('id');
            $product = Product::find($id);

        }

        if ($request->has('submit')) {
            $title = $request->get('title');
            $description = $request->get('description');
            $price = $request->get('price');
            $uploadOk = null;

            if ($request->hasFile('fileToUpload')) {

                $file = $request->file('fileToUpload');
                $admin_session = session()->get('admin');
                $file_ext = $file->getClientOriginalExtension();
                $idx2 = md5(date('Y/m/d') + $admin_session);
                $newFileName = $idx2 . "." . $file_ext;
                $target_file = "images/" . $newFileName;
                @$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                $uploadOk = false;
                if ($check == true) {
                    $msg = __('The file is a image') . " - " . $check["mime"] . ".";
                    if (file_exists($target_file)) {
                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                            $msg = __('The file is large. Max. 50MB');
                        } else {
                            if (in_array($file_ext, ['.jpg', '.jpeg', '.png', '.gif'])) {
                                $msg = __('The format not is correct !');
                            }
                        }
                    }
                    $uploadOk = true;
                } else {
                    $uploadOk == false;
                    $msg = __('The file not is image');
                }
            }
            if (!$request->has('id')) {

                if (!$title) {
                    $msg = __('Title not is set !');
                } elseif (!$description) {
                    $msg = __('Description not is set !');
                } elseif (!$price) {
                    $msg = __('Price not is set !');
                } else {

                    if (isset($target_file) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $product->title = $title;
                        $product->description = $description;
                        $product->price = $price;
                        $product->save();

                        $idxx = "images/" . $product->id;
                        $new_name = $idxx . "." . $file_ext;
                        rename("images/$newFileName", "$new_name");
                        header("Refresh: 3;url=/products");
                        $msg = __('The product is added.');
                    } else {
                        $msg = __('Error Upload. Please upload file before add an product !');
                    }
                }

            } else {
                if ($uploadOk === false) {

                } elseif (!$title) {
                    $msg = __('Title not is set !');
                } elseif (!$description) {
                    $msg = __('Description not is set !');
                } elseif (!$price) {
                    $msg = __('Price not is set !');
                } else {

                    if ($uploadOk === true) {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $idxx = "images/" . $product->id;
                            $new_name = $idxx . "." . $file_ext;
                            rename("images/$newFileName", "$new_name");
                            $msg = __('The product is added.');
                        }
                    }

                    if ($uploadOk === true || $uploadOk === null) {
                        $product->title = $title;
                        $product->description = $description;
                        $product->price = $price;
                        $product->save();
                        header("Refresh: 3;url=/products");
                        $msg = __('The product is updated.');
                    } else {
                        $msg = __('Error Update !');
                    }
                }
            }
        }
        return view('product', compact('msg', 'product'));

    }

    public function products()
    {
        $this->checkLogin();

        $products = Product::orderBy('id', 'ASC')->get();

        return view('products', compact('products'));
    }

    public function delete(Request $request)
    {
        $this->checkLogin();

        if (($id = $request->has('id')) && ($id = $request->get('id'))) {
            $product = Product::find($id);
            $product->delete();
        }

        return view('delete');
    }
}
