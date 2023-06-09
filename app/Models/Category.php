<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'platform_id'];


    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }


    // accessors
    public function getPictureAttribute()
    {
        $img = $this->image;

        if ($img != null) {
            if (file_exists('storage/categories/' . $img->file))
                return 'storage/categories/' . $img->file;
            else
                return  'storage/image-not-found.png';
        }

        return  'storage/no-image.jpg';
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }
}
