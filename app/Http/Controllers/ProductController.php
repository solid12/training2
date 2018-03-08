<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;


class ProductController extends Controller
{
    public function product(Request $request)
    {
        $msg = '';

        $product = new Product();
        if ($request->has('id')) {
            $id = $request->get('id');
            $product = Product::query()->find($id);
        }

        if ($request->has('submit')) {
            $title = $request->get('title');
            $description = $request->get('description');
            $price = $request->get('price');
            $uploadOk = null;

            if ($request->hasFile('fileToUpload')) {

                $file = $request->file('fileToUpload');
                $fileExt = $file->getClientOriginalExtension();
                $temporaryFileName = time();
                $newFileName = $temporaryFileName . "." . $fileExt;
                $targetPath = "images/" . $newFileName;
                @$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                $uploadOk = false;
                if ($check == true) {
                    $msg = __('The file is a image') . " - " . $check["mime"] . ".";
                    if (file_exists($targetPath)) {
                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                            $msg = __('The file is large. Max. 50MB');
                        } else {
                            if (in_array($fileExt, ['.jpg', '.jpeg', '.png', '.gif'])) {
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

                    if (isset($targetPath) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath)) {
                        $product->title = $title;
                        $product->description = $description;
                        $product->price = $price;
                        $product->save();

                        $newName = "images/" . $product->id . "." . $fileExt;
                        rename("images/$newFileName", $newName);
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
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath)) {
                            $idxx = "images/" . $product->id;
                            $newName = $idxx . "." . $fileExt;
                            rename("images/$newFileName", "$newName");
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
        $products = Product::orderBy('id', 'ASC')->get();

        return view('products', compact('products'));
    }

    public function delete(Request $request)
    {
        if (($id = $request->has('id')) && ($id = $request->get('id'))) {
            $product = Product::find($id);
            $product->delete();
        }

        return view('delete');
    }
}
