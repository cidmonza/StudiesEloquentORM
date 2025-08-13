<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Phone;
use App\Models\Product;

class MainController extends Controller
{
    public function index()
    {
        echo 'Eloquent Relationship';
    }

    public function OneToOne()
    {
        $phone1 = Client::find(12)->phone;

        echo 'ID Cliente: ' . $phone1->client_id .
            ' | ID Phone: ' . $phone1->id .
            ' | Número: ' . $phone1->phone_number;

        echo '<hr>';

        // Lazy loading
        $client1 = Client::find(13); // primeira consulta
        $phone2 = $client1->phone->phone_number; // segunda consulta

        echo 'ID Cliente: ' . $client1->id .
            ' | Nome: ' . $client1->client_name .
            ' | ID Phone: ' . $client1->phone->id . // terceira consulta
            ' | Número: ' . $phone2;

        echo '<hr>';

        // Eager loading
        $client2 = Client::with('phone')->find(10); // primeira consulta

        echo 'ID Cliente: ' . $client2->id .
            ' | Nome: ' . $client2->client_name .
            ' | ID Phone: ' . $client2->phone->id .
            ' | Número: ' . $client2->phone->phone_number;

        echo '<hr>';

        // Exemplo do porquê o eager loading é mais interessante:
        // Versão sem eager loading
        $startLazy = microtime(true);
        $clients = Client::all(); // sem eager loading

        echo 'For each client print phone number:<br><br>';

        foreach ($clients as $client) {
            echo $client->phone->phone_number; // cada um faz uma nova consulta...sim, ao invés de cada client já ter um join da tabela phone congruente, ele faz individualmente uma consulta no banco de dados para cada cliente do array de clientes
        }

        $endLazy = microtime(true);
        $timeLazy = $endLazy - $startLazy;

        echo "⏱️ Lazy loading levou: " . number_format($timeLazy, 6) . " segundos<br><hr>";

        // Versão com eager loading
        $startEager = microtime(true);
        $clients2 = Client::with('phone')->get(); // Com eager loading... duas consultas apenas

        echo 'For each client print phone number:<br><br>';

        foreach ($clients2 as $client) {
            echo $client->phone->phone_number; // sem consultas extras
        }

        $endEager = microtime(true);
        $timeEager = $endEager - $startEager;

        echo "⏱️ Eager loading levou: " . number_format($timeEager, 6) . " segundos<br><hr>";
    }

    public function OneToMany()
    {
        // busca o id e o nome do cliente e todos os telefones dele
        // $client1 = Client::find(10);
        // $phones = $client1->phones;
        // echo 'Cliente: ' . $client1->client_name . '<br>';
        // echo 'Phones: <br>';
        // foreach($phones as $index => $phone)
        // {
        //     echo 'Phone ' . $index + 1 . ' |' . ' ' . $phone->phone_number . ' <br>';
        // }

        // $client2 = Client::with('phones')->find(10);
        // echo '<br>';
        // echo 'Cliente: ' . $client2->client_name . '<br>';
        // echo 'Phones: <br>';
        // foreach($client2->phones as $index => $phone)
        // {
        //     echo 'Phone ' . $index + 1 . ' |' . ' ' . $phone->phone_number . ' <br>';
        // }

        $clients = Client::with('phones')->get();
        foreach($clients as $index => $client)
        {
            echo 'Cliente número: ' . $index . ' | Nome: ' . $client->client_name . '<br>Phones: <br>';
            foreach($client->phones as $phone)
            {
                echo $phone->phone_number . '<br>';
            }
            echo '<br>';
        }
    }

    public function BelongTo()
    {
        // $phone1 = Phone::find(10);
        // $client1 = $phone1->client;
        // echo 'Telefone: ' . $phone1->phone_number . '<br>';
        // echo 'Client: ' . $client1->client_name;

        // $phone2 = Phone::with('client')->find(10);
        // echo 'Telefone: ' . $phone2->phone_number . '<br>';
        // echo 'Cliente: ' . $phone2->client->client_name;

        $phones = Phone::with('client')->get();
        foreach($phones as $index => $phone)
        {
            echo 'Phone: ' . $phone->phone_number . ' | do cliente: ' . $phone->client->client_name . '<br>';
        }
    }

    public function ManyToMany()
    {
        // buscar um cliente e todos os produtos que ele comprou
        $client1 = Client::find(1);
        $products = $client1->products;

        echo 'Cliente: ' . $client1->client_name . '<br>';
        echo 'Produtos: <br>';

        foreach($products as $product)
        {
            echo $product->product_name . '<br>';
        }

        // buscar um produto e todos os clientes que o comprou
        $product1 = Product::find(1);
        $clients = $product1->clients;

        echo '<br>';
        echo 'Produto: ' . $product1->product_name . '<br>';
        echo 'Clientes: <br>';

        foreach($clients as $client)
        {
            echo $client->client_name . '<br>';
        }
    }

    // Query builder
    public function RunningQueries()
    {
        // vamos buscar um cliente e seus telefones, mas só queremos os telefones que começam com o numero 8
        // $client1 = Client::find(1);
        // $phones = $client1->phones()->where('phone_number', 'like', '8%')->get();

        // echo 'Cliente: ' . $client1->client_name . '<br>';
        // echo 'Telefones: <br>';
        // foreach($phones as $phone)
        // {
        //     echo $phone->phone_number . '<br>';
        // }

        // buscar todos os produtos que um cliente comprou, mas só queremos os produtos que custam mais de 50
        // $client2 = Client::find(1);
        // $products = $client2
        //             ->products()
        //             ->where('price', '>', 50)
        //             ->orderBy('product_name')
        //             ->get();

        // echo 'Cliente: ' . $client2->client_name . '<br>';
        // echo 'Seus produtos com preço maior que 50:' . '<br>';
        // echo '<hr>';
        // foreach($products as $product)
        // {
        //     echo 'Nome: ' . $product->product_name . ' | Preço: ' . $product->price . '<br>';
        // }

        // vão aparecer produtos repetidos. Para evitar isso, podemos usar o método distinct()
        // vamos ordenar os producots por ordem alfabética do nome
        // echo '<br>'

        $client3 = Client::find(1);
        $products2 = $client3->products()
                            ->where('price', '>', 50)
                            ->distinct() // busca todos os produtos, sem que eles se repitam caso tenha tido várias compras do mesmo
                            ->orderBy('product_name', 'desc')
                            ->get();

        echo 'Cliente: ' . $client3->client_name . '<br>';
        echo 'Seus produtos com preço maior que 50:' . '<br>';
        echo '<hr>';
        foreach($products2 as $product)
        {
            echo 'Nome: ' . $product->product_name . ' | Preço: ' . $product->price . '<br>';
        }

    }

    // Mesmos resultados sem relações
    public function SameResults()
    {
        // vamos buscar os mesmos resultados, mas sem usar as relações
        // vamos buscar um cliente e os seus telefones
        // $client1 = Client::find(1);
        // $phones = Phone::where('client_id', $client1->id)->get();
        // echo 'Cliente: ' . $client1->client_name . '<br>';
        // echo 'Telefones: <br>';
        // foreach($phones as $phone)
        // {
        //     echo $phone->phone_number . '<br>';
        // }

        $client2 = Client::find(1);
        $products = Product::join('orders', 'products.id', '=', 'orders.product_id')
                            ->where('orders.client_id', $client2->id)
                            ->get();
        echo '<br>';
        echo 'Cliente: ' . $client2->client_name . '<br>';
        echo 'Produtos: <br>';
        foreach($products as $product)
        {
            echo $product->product_name . ' | ' . $product->price . '<br>';
        }
    }
}
