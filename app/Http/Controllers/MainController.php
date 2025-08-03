<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TesteModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Buscar todos os dados dos produtos
        $results = Product::all(); // SELECT * FROM products

        // foreach($results as $product){
        //     echo "<br>";
        //     echo $product->product_name;
        // }

        // echo $results[0]->product_name;

        // Buscar todos os dados como um array associativo
        //$results = Product::all()->toArray();

        // retornar os resultados como um array de objetos stdClass
        //$results = $this->arrayOfObject(Product::all()->toArray());

        // Buscar produtos ordenados pelo nome alfabeticamente

        // $results = Product::orderBy('product_name')
        //                     ->get()
        //                     ->toArray();

        // Buscar os 3 primeiros produtos
        //$results = Product::limit(3)->get()->toArray();

        // Buscar produto pelo id
        $results = Product::find(10)->toArray();

        $this->showData($results);

    }

    private function showData($data){
        echo '<pre>',
        print_r($data);
    }

    private function arrayOfObject($data){
        $tmp = [];
        foreach($data as $key => $value){
            $tmp[] = (object) $value;
        }
        return $tmp;
    }
}
