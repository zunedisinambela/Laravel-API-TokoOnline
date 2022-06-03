<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = ['id'];

    public function latestImage()
    {
        return $this->hasOne(ImagesProduct::class, 'product_id', 'id')->latest();
    }

    public function imageRelation()
    {
        return $this->hasMany(ImagesProduct::class, 'product_id', 'id');
    }
}
