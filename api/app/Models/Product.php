<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manufacturer',
        'price',
        'categories_id',
        'subCategories_id',
        'imageOne',
        'imageTwo',
        'imageThree'
    ];
}
