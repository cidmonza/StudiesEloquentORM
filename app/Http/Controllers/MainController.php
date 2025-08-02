<?php

namespace App\Http\Controllers;

use App\Models\TesteModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $products = TesteModel::all()->toArray();
        echo "<pre>";
        print_r($products);
    }
}
