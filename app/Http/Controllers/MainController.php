<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TesteModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Buscar todos os dados dos produtos
        //$results = Product::all(); // SELECT * FROM products

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
        //$results = Product::find(10)->toArray();

        // Buscar com clausura where
        //$results = Product::where('price', '>=', 70)
        //                     ->get()
        //                     ->toArray();

        // Buscar apenas o primeiro resultado
        //$results = Product::where('price', '>=', 70)
        //             ->first()
        //             ->toArray();

        // Buscar apenas o primeiro elemento se ele existir, caso contrário, retorna array vazio
        //$results = Product::where('price', '>=', '170')
        //                     ->firstOr(function(){return [];});

        // Forma Laravel Style de fazer o query de cima:
        //$results = Product::where('price', '>=', 170)->firstOrNew();

        // $product = Product::find(10);
        // echo $product->price; // valor do db
        // echo '<br>';

        // $product->price = 200; // define preço no código, não no db
        // echo $product->price;
        // echo '<br>';

        // $product->refresh(); // volta a recuperar o preço original que está no db
        // echo $product->price;
        // echo '<br>';

        // $this->showData($results);

        // $product = Product::firstWhere('price', '>=', 90);
        // echo $product->product_name . ' tem um preço de ' . $product->price . ' R$ <br>';

        // $product = Product::findOr(100, function(){
        //     echo 'Não foi encontrado o produto desejado';
        // });

        // procura, se não tiver, falha, 404
        // $product = Product::findOrFail(200);
        // echo $product->product_name . ' tem um preço de ' . $product->price . ' R$ <br>';

        // formas de buscar agregados
        // laravel.com/docs/12.x/eloquent
        // $total_products = Product::count();
        // $product_max_price = Product::max('price');
        // $product_min_price = Product::min('price');
        // $product_avg_price = Product::avg('price');
        // $product_sum_price = Product::sum('price');

        // $results = [
        //     'total_products' => $total_products,
        //     'product_max_price' => $product_max_price,
        //     'product_min_price' => $product_min_price,
        //     'product_avg_price' => $product_avg_price,
        //     'product_sum_price' => $product_sum_price
        // ];

        // $this->showData($results);

        // INSERT INTO products(product_name, price) VALUES ('Novo Produto', 50);
        // Inserir novo produto na tabela products
        // $new_product = new Product();
        // $new_product->product_name = 'Novo Produto';
        // $new_product->price = 50;
        // $new_product->save();

        // precisa ter como propriedade no model o "fillabe"
        // Product::create([
        //     'product_name' => 'Produto 2',
        //     'price' => 55
        // ]);

        // com insert, não é inserido o created at e updated at
        // Product::insert([
        //     [
        //     'product_name' => 'Produto 5',
        //     'price' => 56,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        //     ],
        //     [
        //     'product_name' => 'Produto 6',
        //     'price' => 99,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        //     ]
        // ]);

        // Update
        // SELECT * FROM products WHERE id = 10
        // $product = Product::find(10);
        // $product->product_name = 'Produto Alterado!';
        // $product->price = 10;
        // $product->save();

        // alterar o preço de todos os produtos :)
        // Product::where('id', '<=', 10)
        // ->update([
        //     'price' => 999
        // ]);

        // atualizar se existir, se não, cria
        // Product::updateOrCreate(
        //     ['product_name' => 'xarope'],
        //     ['price' => 25]
        // );

        // Hard delete e Soft delete (colocar use SoftDeletes; no model)

        // $product = Product::find(10);
        // $product->delete();

        // // Deleta tudo da tabela products
        // Product::truncate();

        // Product::destroy(1,2,3);
        // Product::destroy([1,2,3]);

        // Product::where('price', '>=', 50)->delte();

        // Soft deletes (use SoftDeletes; foi adicionado ao model Product)

        $product = Product::find(25);
        $product->delete(); // adiciona data me deleted_at

        // recuperar produto

        $product = Product::withTrashed()->find(25);
        $product->restore();

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
