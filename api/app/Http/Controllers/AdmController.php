<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class AdmController extends Controller
{
    public function createCategory(Request $request) {

        $pathImageOne = $request->file('imageOne')->store($request->category, 'public');
        $pathImageTwo = $request->file('imageTwo')->store($request->category, 'public');

        $category = Category::create([
            'name' => $request->category,
            'banner1' => $pathImageOne,
            'banner2' => $pathImageTwo,
        ]);

        return $category;

    }

    public function createSubCategory(Request $request) {

        $idCategory = Category::where('name', $request->category)->get()->first();

        $subCategory = SubCategory::create([
            'name' => $request->subCategoryName,
            'categories_id' => $idCategory->id,
        ]);

        return $subCategory;

    }
}
