@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Formulário de Registro de Produtos</div>
                  <div  style="padding: 30px">

                    <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->

                      <h4>Cadastrar/Alterar Produto</h4>
                        <hr>
                         <form action="{{ url(Request::path()) }}" method="POST">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                          <label id="nome">Nome:</label>
                          <input type="text" name="nome" value="{{ $produto->nome }}" id="input-nome" class="form-control">
                        </div>
                        <div class="form-group">
                          <label id="nome">Descricao:</label>
                          <input type="text" name="descricao"  value="{{ $produto->descricao }}" id="input-descricao" class="form-control">
                        </div>
                        <div class="form-group">
                          <label id="nome">Código do Fornecedor:</label>
                          <select name="fornecedor_id" id="input-fornecedor" class="form-control">
                             @if(!empty($produto->fornecedor_id))
                                <option value="{{ $produto->fornecedor->id }}">{{ $produto->fornecedor->nome }}</option>
                             @endif
                             @foreach($fornecedores as $fornecedor)
                              <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                             @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label id="nome">Preço:</label>
                          <input type="text" name="preco" value="{{ $produto->preco }}" id="input-custo" class="form-control">
                        </div>
                        <div class="form-group">
                          <label id="nome">Quantidade:</label>
                          <input type="text" name="quantidade" value="{{ $produto->quantidade }}" id="input-quantidade" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" id="btn_novo_contato">Salvar</button>
                        <a href="/produtos" class="btn btn-default">Voltar</a>
                      </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>

@endsection


