
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listagem de Usuários</div>
                  <div  style="padding: 30px">
                    <form action="/consultar-usuarios" method="get">
                      <div class="row">
                        <div class="col-md-4 text-center col-md-offset-4">
                          <div class="form-group">
                            <label id="busca">Buscar:</label>
                            <input type="text" name="busca" id="input-email" placeholder="buscar por nome..." class="form-control">
                          </div>
                          <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                      </div>
                    </form><br><br>
                  <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->
                  <p>
                      <ul>
                          @foreach($usuarios as $usuario)
                              <b>Usuário -> ID -> {{ $usuario->id }}</b><br>
                              <li> Nome: {{ $usuario->name }} </li>
                              <li> E-mail: {{ $usuario->email }} </li>
                              <li> Tipo: {{ $usuario->tipo }} </li>
                              <li> Status: {{ $usuario->status }} </li>
                              <li>Opções: <a href="/cadastrar-usuario">Cadastrar</a> <a href="/alterar-usuario/{{ $usuario->id }}">Alterar</a> 
                              @if($usuario->status == 'inativo')
                                <a href="/ativar-usuario/{{ $usuario->id }}">Ativar</a></li>
                              @else
                                <a href="/desativar-usuario/{{ $usuario->id }}">Desativar</a></li>
                              @endif
                              <br>
                          @endforeach
                      </ul>
                  </p>
                      </div>
                  </div>
                </div>
              </div>
            </div>

@endsection