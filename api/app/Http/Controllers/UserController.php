<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class UserController extends Controller
{
    public function getCategories() {
        
        $categories = Category::query()->orderBy('id')->get();

        return $categories;

    }
}
