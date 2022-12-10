<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Size;

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

        $categories = Category::all();
        return $categories;

    }

    public function createSubCategory(Request $request) {

        $idCategory = Category::where('name', $request->category)->get()->first();

        $subCategory = SubCategory::create([
            'name' => $request->subCategoryName,
            'categories_id' => $idCategory->id,
        ]);

        $subCategories = SubCategory::all();

        return $subCategories;

    }

    public function createProduct(Request $request) {

        $category = Category::where('name', $request->category)->get()->first();        
        
        $subCategory = SubCategory::where('categories_id', $category->id)->get()->first();

        $imageOne = $request->file('imageOne')->store($request->name, 'public');
        $imageTwo = $request->file('imageTwo')->store($request->name, 'public');
        
        if($request->imageThree) {

            $imageThree = $request->file('imageThree')->store($request->name, 'public');

            $product = Product::create([
                'name' => $request->name,
                'manufacturer' => $request->manufacturer,
                'price' => $request->price,
                'categories_id' => $category->id,
                'sub_categories_id' => $subCategory->id,
                'imageOne' =>  $imageOne,
                'imageTwo' => $imageTwo,
                'imageThree' => $imageThree
            ]);
    
        } else {

            $product = Product::create([
                'name' => $request->name,
                'manufacturer' => $request->manufacturer,
                'price' => $request->price,
                'categories_id' => $category->id,
                'sub_categories_id' => $subCategory->id,
                'imageOne' =>  $imageOne,
                'imageTwo' => $imageTwo,
            ]);
    
        }

        if($request->sizeP){
            $size = Size::create([
                'size' => 'P',
                'quantity' => $request->qtdP,
                'products_id' => $product->id,
            ]);
        }
        if($request->sizeM){
            $size = Size::create([
                'size' => 'M',
                'quantity' => $request->qtdM,
                'products_id' => $product->id,
            ]);
        }
        if($request->sizeG){
            $size = Size::create([
                'size' => 'G',
                'quantity' => $request->qtdG,
                'products_id' => $product->id,

            ]);
        }
        if($request->sizeGG){
            $size = Size::create([
                'size' => 'GG',
                'quantity' => $request->qtdGG,
                'products_id' => $product->id,
            ]);
        }

        $sizes = Size::query()->orderBy('id')->get();
        $products = Product::query()->orderBy('id')->get();

        return [$products, $sizes];

    }
}
