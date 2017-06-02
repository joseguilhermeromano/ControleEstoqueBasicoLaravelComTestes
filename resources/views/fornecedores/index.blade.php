@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listagem de Fornecedores</div>
                  <div  style="padding: 30px">
                  <form action="/consultar-fornecedores" method="get">
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
                    <a href="/cadastrar-fornecedor" class="text-center">Cadastrar</a><br><br>
                  <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->
                  <p>
                      <ul>
                      
                          @foreach($fornecedores as $fornecedor)
                              <b>Fornecedor -> ID -> {{ $fornecedor->id }}</b><br>
                              <li> Nome: {{ $fornecedor->nome }} </li>
                              <li> Endereco: {{ $fornecedor->endereco }} </li>
                              <li> CNPJ: {{ $fornecedor->cnpj }} </li>
                              <li><a href="/cadastrar-fornecedor">Cadastrar</a><a href="/alterar-fornecedor/{{ $fornecedor->id }}">Alterar</a><a href="excluir-fornecedor/{{ $fornecedor->id }}">Excluir</a></li>
                              <br>
                          @endforeach
                      </ul>
                  </p>
                  </div>
                </div>
              </div>
            </div>

@endsection
