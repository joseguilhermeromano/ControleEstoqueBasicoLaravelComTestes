@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Listagem de Produtos</div>
                  <div  style="padding: 30px">
                  <form action="/consultar-produtos" method="get">
                      <div class="row">
                        <div class="col-md-4 text-center col-md-offset-4">
                          <div class="form-group">
                            <label id="busca">Buscar:</label>
                            <input type="text" name="busca" id="input-email" placeholder="buscar por nome..." class="form-control"><br>
                            @if(!empty($fornecedores))
                            <select name="fornecedor">
                              <option value="-1" selected disabled>Selecione um Fornecedor</option>
                              @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                              @endforeach
                            </select>
                            @endif
                          </div>
                          <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                      </div>
                    </form><br><br>
                    <a href="/cadastrar-produto" class="text-center">Cadastrar</a><br><br>
                  <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->
                  <p>
                      <ul>
                          @foreach($produtos as $produto)
                          @if($produto->quantidade == 0)
                              <h5><b>Produto zerado em estoque</b></h5>
                              <b>Produto -> ID -> {{ $produto->id }}</b><br>
                              <li> Nome: {{ $produto->nome }} </li>
                              <li> Descrição: {{ $produto->descricao }} </li>
                              <li> Fornecedor: {{ $produto->fornecedor->nome }} </li>
                              <li> Preço: {{ $produto->preco }} </li>
                              <li> Quantidade: {{ $produto->quantidade }} </li>
                              <li><a href="/cadastrar-produto">Cadastrar</a> <a href="/alterar-produto/{{ $produto->id }}">Alterar</a>
                              <br><br>
                          @endif
                          @endforeach
                      </ul>
                      <br><br>
                      <ul>
                     
                          @foreach($produtos as $produto)
                          @if($produto->quantidade > 0)
                              <b>Produto -> ID -> {{ $produto->id }}</b><br>
                              <li> Nome: {{ $produto->nome }} </li>
                              <li> Descrição: {{ $produto->descricao }} </li>
                              <li> Fornecedor: {{ $produto->fornecedor->nome }} </li>
                              <li> Preço: {{ $produto->preco }} </li>
                              <li> Quantidade: {{ $produto->quantidade }} </li>
                              <li><a href="/cadastrar-produto">Cadastrar</a> <a href="/alterar-produto/{{ $produto->id }}">Alterar</a>
                              <br><br>
                          @endif
                          @endforeach
                      </ul>

                  </p>
                  </div>
                </div>
              </div>
            </div>

@endsection


