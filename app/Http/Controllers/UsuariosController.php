<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class UsuariosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }    

    public function index() {
        if(Auth::user()->tipo != 'admin') return abort('403', 'Acesso não autorizado!');
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function insert(Request $request) {
        $usuario = new User();
        if(empty($request->all())){ return view('usuarios.form',compact("usuario"));}
        if(Auth::user()->tipo != 'admin') return abort('403');
        if($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 'ativo',
            'tipo' => $request->tipo
        ])){
        	$request->session()->flash('alert-success', 'O Usuário foi cadastrado com sucesso!');
        }else{
        	$request->session()->flash('alert-danger', 'Não foi possível cadastrar o usuário!');
        }
        

        return $this->index();
    }

    public function update(Request $request, $id){
        if(Auth::user()->tipo != 'admin') return abort('403');
        $usuario = User::find($id);
        if(empty($request->all())){ return view('usuarios.form', compact('usuario'));}
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->tipo = $request->tipo;
        $usuario->status = empty($request->status) ? "ativo" : $request->status;

        if($usuario->save()){
            $request->session()->flash('alert-success', 'O Usuário foi atualizado com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível atualizar o usuário!');
        }
        return view('usuarios.form', compact('usuario'));
    }

    public function disable(Request $request, $id){
        if(Auth::user()->tipo != 'admin') return abort('403');
        $usuario = User::find($id);
        $usuario->status = "inativo";
        if($usuario->save()){
            $request->session()->flash('alert-success', 'O Usuário foi desativado com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível desativar o usuário!');
        }
        return $this->index();
    }
    
    public function enable(Request $request, $id){
        if(Auth::user()->tipo != 'admin') return abort('403');
        $usuario = User::find($id);
        $usuario->status = "ativo";
        if($usuario->save()){
            $request->session()->flash('alert-success', 'O Usuário foi ativado com sucesso!');
        }else{
            $request->session()->flash('alert-danger', 'Não foi possível ativar o usuário!');
        }
        return $this->index();
    }

    public function search(Request $request){
         if(Auth::user()->tipo != 'admin') return abort('403');
         $usuarios = User::where('name', 'like', '%' . $request->busca . '%')->get();
         return view('usuarios.index', compact('usuarios'));
    }
}
