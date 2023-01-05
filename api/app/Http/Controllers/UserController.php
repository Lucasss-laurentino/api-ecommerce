<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function createUser(Request $request) {

        $user = User::where('email', $request->emailCreate)->get()->first();

        if($user){
        
            return response()->Json('', 412);
        
        } else {
            
            $userCreated = User::create([
                'email' => $request->emailCreate,
                'password' => Hash::make($request->passwordCreate),
            ]);

            $token = $userCreated->createToken('token');

            return [$userCreated, $token->plainTextToken];
        }
        
    }

    public function login(Request $request) {
        
        $credentials = $request->only(['email', 'password']);

        if(Auth::attempt($credentials)) {
            
            $user = User::where('email', $credentials['email'])->get()->first();
            
            $token = $user->createToken('token');

            return [$user, $token->plainTextToken];
        
        } else {
            return response()->Json('Unauthorized', 401);
        }


    }

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

    public function getProductsThisUser($id) {

        $carts = Cart::where('users_id', $id)->get();

        if($carts->count() > 0){

            foreach($carts as $cart) {

                $products[] = Product::where('id', $cart->products_id)->get();
            }
            
            return response()->Json($products);
    
        } else {
            return $carts;
        }

    }

    public function deleteItemCart($id) {
        $cart = Cart::where('products_id', $id)->get()->first();

        $cart->delete();

        
        return 'delete';
    }

    public function createAddress(Request $request) {

        $address = Address::where('user_id', $request->user_id);

        if($address){
            $address->delete();
        }

        $newAddress = Address::create([

            'cep' => $request->cep,
            'state' => $request->state,
            'city' => $request->city,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'user_id' => $request->user_id,
        ]);

        return $newAddress;
    }

    public function getAddress($id) {
    
        $address = Address::where('user_id', $id)->get()->first();
        
        return $address;
    
    }
}
