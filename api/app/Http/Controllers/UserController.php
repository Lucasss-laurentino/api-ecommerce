<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;


class UserController extends Controller
{
    public function getCategories() {
        
        $categories = Category::query()->orderBy('id')->get();

        return $categories;

    }

    public function getSubCategories($name) {

        $category = Category::where('name', $name)->get()->first();

        $subCategories = SubCategory::where('categories_id', $category->id)->get();

        return $subCategories;

    }

    public function getCategoryDefault() {
        
        $categoryDefault = Category::where('id', 1)->get()->first();

        return $categoryDefault;
    
    }

    public function getProduct() {

        $products = Product::query()->orderBy('created_at')->get();

        return $products;

    }

    public function getProductThisSubCategory($id) {
        
        $products = Product::query()->orderBy('id')->get();

        return $products;

    }

}
