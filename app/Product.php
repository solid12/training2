<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getImage($id)
    {
        $images = glob('images/' .$id. '.{jpg,jpeg,png,gif,bmp,tiff}', GLOB_BRACE);
        return count($images) ? $images[0] : null;
    }

    public $timestamps = false;

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $result = parent::toArray();
        $result['image'] = $this->getImage($this->getKey());

        return $result;
    }

    public function product()
    {
        return $this->hasOne('App\Category');
    }


}
