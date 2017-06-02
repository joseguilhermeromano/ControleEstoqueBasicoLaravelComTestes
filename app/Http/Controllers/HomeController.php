<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Produto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        $valorTotal = 0;
        if(Auth::user()->tipo == 'admin'){
            foreach ($produtos as $produto) {
                $valorTotal += $produto->quantidade * $produto->preco;
            }
            return view('home', compact('valorTotal'));
        }

        return view('home');
        
    }
}
