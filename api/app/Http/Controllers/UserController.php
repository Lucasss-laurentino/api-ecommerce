<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;


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

}
