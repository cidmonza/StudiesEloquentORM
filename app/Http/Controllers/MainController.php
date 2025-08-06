<?php

namespace App\Http\Controllers;

use App\Models\Client;

class MainController extends Controller
{
    public function index()
    {
        echo 'Eloquent Relationship';
    }

    public function oneToOne(){

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
