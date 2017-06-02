<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Fornecedor;
use App\Produto;

class FornecedoresController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $fornecedores = Fornecedor::all();

        return view('fornecedores.index', compact('fornecedores'));
    }

    public function insert(Request $request) {
        $fornecedor = new Fornecedor();
        if(empty($request->all())){ return view('fornecedores.form',compact("fornecedor"));}
        if($fornecedor = Fornecedor::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cnpj' => $request->cnpj
        ])){
        	$request->session()->flash('alert-success', 'O Fornecedor foi cadastrado com sucesso!');
        }else{
        	$request->session()->flash('alert-danger', 'Não foi possível cadastrar o fornecedor!');
        }
        

        return $this->index();
    }

    public function update(Request $request, $id){
        $fornecedor = Fornecedor::find($id);
        if(empty($request->all())){ return view('fornecedores.form', compact('fornecedor'));}
        $fornecedor->nome = $request->nome;
        $fornecedor->endereco = $request->endereco;
        $fornecedor->cnpj = $request->cnpj;

        if($fornecedor->save()){
            $request->session()->flash('alert-success', 'O Fornecedor foi atualizado com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível atualizar o fornecedor!');
        }
        return view('fornecedores.form', compact('fornecedor'));
    }


    public function search(Request $request){
         $fornecedores = Fornecedor::where('nome', 'like', '%' . $request->busca . '%')->get();
         return view('fornecedores.index', compact('fornecedores'));
    }

    public function delete(Request $request, $id){
        $fornecedor = Fornecedor::find($id);

       $produtos = Produto::where('fornecedor_id', $id)->get();

        if(!$produtos->isEmpty()){
            $request->session()->flash('alert-danger', 'Não foi possível excluir o fornecedor, pois este contém produtos associados!');
            return $this->index();
        }

        if($fornecedor->delete($fornecedor)){
            $request->session()->flash('alert-success', 'O Fornecedor foi excluído com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível excluir o fornecedor!');
        }
        return $this->index();
    }
}
