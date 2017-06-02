@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Formulário de Registro de Fornecedores</div>
                  <div  style="padding: 30px">
                    <div class="flash-message">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                      @endforeach
                    </div> <!-- end .flash-message -->
                  <h4>Cadastrar/Aleterar Fornecedores</h4>
                    <hr>
                     <form action="{{ url(Request::path()) }}" method="POST">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <label id="nome">Nome:</label>
                      <input type="text" name="nome" value="{{ $fornecedor->nome }}" id="input-nome" class="form-control">
                    </div>
                    <div class="form-group">
                      <label id="nome">Endereço:</label>
                      <input type="text" name="endereco" value="{{ $fornecedor->endereco }}" id="input-endereco" class="form-control">
                    </div>
                    <div class="form-group">
                      <label id="nome">CNPJ:</label>
                      <input type="text" name="cnpj" value="{{ $fornecedor->cnpj }}" id="input-cnpj" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="/fornecedores" class="btn btn-default">Voltar</a>
                  </form>
                  </div>
                </div>
              </div>
            </div>

@endsection
