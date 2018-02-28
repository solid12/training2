<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getImage()
    {
        $images = glob('images/' .$this->getKey(). '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
        return count($images) ? $images[0] : null;
    }
}
