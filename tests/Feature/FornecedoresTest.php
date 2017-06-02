<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\Fornecedor;
use App\User;
use App\Produto;


class FornecedoresTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */

    public function usuario_pode_listar_todos_os_fornecedores_cadastrados(){
    	$usuario = factory(User::class)->create();
    	$fornecedor = factory(Fornecedor::class)->create();

    	Auth::login($usuario);

    	$response = $this->get('/fornecedores');

    	$response->assertSee($fornecedor->nome);
    	$response->assertSee($fornecedor->cnpj);
    	$response->assertSee($fornecedor->endereco);
    }

    /** @test */

    public function usuario_pode_cadastrar_fornecedor(){
    	$usuario = factory(User::class)->create();
        $fornecedor = factory(Fornecedor::class)->make();

        Auth::login($usuario);
        $response = $this->post('/cadastrar-fornecedor', [
                'nome' => $fornecedor->nome,
                'cnpj' => $fornecedor->cnpj,
                'endereco' => $fornecedor->endereco
            ]);
        
        $response->assertSee($fornecedor->nome);
        $response->assertSee($fornecedor->cnpj);
        $response->assertSee($fornecedor->endereco);
    }

    /** @test */

    public function usuario_pode_alterar_registro_de_fornecedor(){
    	$usuario = factory(User::class)->create();        
        Auth::login($usuario);

        $fornecedor = factory(Fornecedor::class)->create();

        $response = $this->post('/alterar-fornecedor/'.$fornecedor->id, [
            'nome' => "teste",
            'cnpj' => "teste",
            'endereco' => "teste"
        ]);

        $fornecedor = Fornecedor::find($fornecedor->id);
        $response->assertStatus(200);
        $this->assertEquals($fornecedor->nome, "teste");
        $this->assertEquals($fornecedor->cnpj, "teste");
        $this->assertEquals($fornecedor->endereco, "teste");
    }

    /** @test */

    public function usuario_pode_consultar_fornecedores(){
    	$usuario = factory(User::class)->create();        
        Auth::login($usuario);
        $fornecedor = factory(Fornecedor::class)->create(['nome' => 'testando']);

        $response = $this->post('/cadastrar-fornecedor', [
            'nome' => $fornecedor->nome,
            'cnpj' => $fornecedor->cnpj,
            'endereco' => $fornecedor->endereco,
        ]);

        $response = $this->get('/consultar-fornecedores?busca='.$fornecedor->nome);
        $response->assertStatus(200);
        $response->assertSee($fornecedor->nome);
        $response->assertSee($fornecedor->cnpj);
        $response->assertSee($fornecedor->endereco);
        $fornecedor = Fornecedor::where('nome', $fornecedor->nome);
        $this->assertNotNull($fornecedor);
    }

    /** @test */

    public function usuario_pode_excluir_fornecedores(){
    	$usuario = factory(User::class)->create();        
        Auth::login($usuario);

        $fornecedor = factory(Fornecedor::class)->create();

        $response = $this->post('/excluir-fornecedor/'.$fornecedor->id);

        $response->assertStatus(200);
        $fornecedor = Fornecedor::find($fornecedor->id);
        $this->assertNull($fornecedor);
        $response->assertSee("O Fornecedor foi excluído com sucesso!");
    }

        /** @test */

    public function usuario_nao_pode_excluir_fornecedores_com_produtos_associados(){
        $usuario = factory(User::class)->create();        
        Auth::login($usuario);

        $fornecedor = factory(Fornecedor::class)->create();

        $produto = factory(Produto::class)->create(['fornecedor_id' => $fornecedor->id]);


        $response = $this->post('/excluir-fornecedor/'.$fornecedor->id);

        $response->assertStatus(200);
        $fornecedor = Fornecedor::find($fornecedor->id);
        $this->assertNotNull($fornecedor);
        $response->assertSee("Não foi possível excluir o fornecedor, pois este contém produtos associados!");
    }
}
