<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Cart;

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

    public function getSizeThisProduct($id) {
        $sizes = Size::where('products_id', $id)->get();

        return $sizes;
    }

    public function getPriceCor(Request $request) {

        $params = http_build_query($request->args);

        $path = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?'.$params;

        $curl = curl_init(); // iniciando curl

        // configurando request
        curl_setopt_array($curl, [
            CURLOPT_URL => $path, // Enviar requisição para esta url
            CURLOPT_RETURNTRANSFER => true, // Retornar resultado em uma variavel
            CURLOPT_CUSTOMREQUEST => 'GET' // usando o metodo get
        ]);

        $response = curl_exec($curl); // enviando request

        curl_close($curl); // fechando conexao

        return response()->Json(simplexml_load_string($response));
    }

    public function addToCart(Request $request) {

        $productsThisUser = Cart::where('users_id', $request->userId)->get();
        
        $productInfo = $request->productInfo;
        $size = $request->sizeSelected;

        if($productsThisUser){
            foreach($productsThisUser as $product){

                if($product->products_id === $productInfo['id']){

                    return 'false';
            
                }
            
            }
    
        }

        $productToCart = Cart::create([

            'products_id' => $productInfo['id'],
            'sizes_id' => $size['id'],
            'users_id' => $request->userId,

        ]);

        return $productToCart;

    }
}
