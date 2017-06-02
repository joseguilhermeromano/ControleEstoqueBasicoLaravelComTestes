
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Formuário de Cadastro/Alteração de Usuários</div>
                  <div  style="padding: 30px">
                  <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->

                  <h4>Cadastrar/Alterar Usuário</h4>
                        <hr>
                        <form action="{{ url(Request::path()) }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                         <input type="hidden" name="id" id="input-id" class="form-control">
                          <label id="name">Tipo:</label>
                          <select name="tipo" class="form-control"> 
                            <option value="{{ empty($usuario->tipo) ? 'comum' : $usuario->tipo }}">Usuário Comum</option>
                            <option value="{{ empty($usuario->tipo) ? 'admin' : $usuario->tipo }}">Usuário Administrador</option>
                          </select>
                        </div>
                        <div class="form-group">
                         <input type="hidden" name="id" id="input-id" class="form-control">
                          <label id="name">Nome:</label>
                          <input type="text" name="name" value="{{ $usuario->name }}" id="input-name" class="form-control">
                        </div>

                        <div class="form-group">
                          <label id="email">Email:</label>
                          <input type="text" name="email" id="input-email" value="{{ $usuario->email }}" class="form-control">
                        </div>
                        @if(empty($usuario->password))
                          <div class="form-group">
                            <label id="password">Senha:</label>
                            <input type="password" name="password" id="input-password" class="form-control">
                          </div>
                        @endif
                        <button type="submit" class="btn btn-primary" id="btn_novo_contato">Salvar</button>
                        <a href="/usuarios" class="btn btn-default">Voltar</a>
                      </form>
                      </div>
                  </div>
                </div>
              </div>
            </div>

@endsection