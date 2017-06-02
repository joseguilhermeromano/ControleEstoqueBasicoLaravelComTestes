<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }  

    public function index()
    {
        $produtos = Produto::all();
        $fornecedores = Fornecedor::all();

        return view('produtos.index', compact('produtos', 'fornecedores'));
    }

    public function insert(Request $request) {
        $produto = new Produto();
        $fornecedores = Fornecedor::all();
        if(empty($request->all())){ return view('produtos.form',compact("produto","fornecedores"));}
        if($produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
            'fornecedor_id' => $request->fornecedor_id
        ])){
        	$request->session()->flash('alert-success', 'O Produto foi cadastrado com sucesso!');
        }else{
        	$request->session()->flash('alert-danger', 'Não foi possível cadastrar o produto!');
        }
        

        return $this->index();
    }

    public function update(Request $request, $id){
        $produto = Produto::find($id);
        $fornecedores = Fornecedor::all();
        if(empty($request->all())){ return view('produtos.form',compact("produto","fornecedores"));}
        $fornecedor = Fornecedor::find($request->fornecedor);
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;
        $produto->fornecedor_id = $request->fornecedor_id;
        if($request->quantidade >= 0){
            $produto->quantidade = $request->quantidade;
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível atualizar o produto! Não há produtos suficientes para a baixa!');
            return view('produtos.form', compact('produto', 'fornecedores'));
        }
        

        if($produto->save()){
            $request->session()->flash('alert-success', 'O Produto foi atualizado com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível atualizar o produto!');
        }
        return view('produtos.form', compact('produto', 'fornecedores'));
    }


    public function search(Request $request){
        $produtos = null;
         if($request->busca !== ''){
             $produtos = Produto::where('nome', 'like', '%' . $request->busca . '%')->get();
        }

        if($request->fornecedor !== null){
            $produtos = Produto::where('fornecedor_id', $request->fornecedor)->get();
        }

          $fornecedores = Fornecedor::all();

         return view('produtos.index', compact('produtos', 'fornecedores'));
    }

    
}
