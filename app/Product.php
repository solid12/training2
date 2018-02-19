<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function getImage($id)
    {
        $image = glob('images/' .$id. '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
        return $image;
    }
}
