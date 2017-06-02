<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\Produto;
use App\Fornecedor;
use App\User;

class ProdutosTest extends TestCase
{

	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

 	/** @test */

    public function usuario_pode_listar_todos_os_produtos_cadastrados(){
    	$usuario = factory(User::class)->create();
    	Auth::login($usuario);

    	$produto = factory(Produto::class)->create();

    	$response = $this->get('/produtos');

    	$response->assertSee($produto->nome);
    	$response->assertSee($produto->descricao);
    	$response->assertSee(strval($produto->quantidade));
    	$response->assertSee(strval($produto->preco));
    	$response->assertSee(strval($produto->fornecedor->id));
    }

    /** @test */

    public function usuario_pode_cadastrar_produto(){
    	$usuario = factory(User::class)->create();
        $produto = factory(Produto::class)->make();

        Auth::login($usuario);
        $response = $this->post('/cadastrar-produto', [
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'quantidade' => $produto->quantidade,
                'fornecedor_id' => $produto->fornecedor->id
            ]);
        
        $response->assertSee($produto->nome);
        $response->assertSee($produto->descricao);
    	$response->assertSee(strval($produto->quantidade));
    	$response->assertSee(strval($produto->preco));
    	$response->assertSee(strval($produto->fornecedor->id));
    }

    /** @test */

    public function usuario_pode_alterar_registro_de_produto(){
    	$usuario = factory(User::class)->create();        
        Auth::login($usuario);

        $produto = factory(Produto::class)->create();

        $response = $this->post('/alterar-produto/'.$produto->id, [
				'nome' => "teste de alteração",
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'quantidade' => $produto->quantidade,
                'fornecedor_id' => $produto->fornecedor->id
        ]);

        $produto = Produto::find($produto->id);
        $response->assertStatus(200);
        $this->assertEquals($produto->nome, "teste de alteração");
    }

    /** @test */

    public function usuario_pode_consultar_produtos_por_nome(){
    	$usuario = factory(User::class)->create();        
        Auth::login($usuario);
        $produto = factory(Produto::class)->create(['nome' => 'testando']);
        $fornecedor = factory(Fornecedor::class)->create();

        $response = $this->post('/cadastrar-produto', [
			'nome' => $produto->nome,
	        'descricao' => $produto->descricao,
	        'preco' => $produto->preco,
	        'quantidade' => $produto->quantidade,
	        'fornecedor_id' => $fornecedor->id
        ]);

        $produto = Produto::find($produto->id);

        $response = $this->get('/consultar-produtos?busca=testando');
        $response->assertStatus(200);
        $response->assertSee($produto->nome);
        $response->assertSee($produto->descricao);
    	$response->assertSee(strval($produto->quantidade));
    	$response->assertSee(strval($produto->preco));
    	$response->assertSee(strval($produto->fornecedor->id));
    }

    public function usuario_pode_consultar_produtos_por_fornecedor(){
        $usuario = factory(User::class)->create();
        Auth::login($usuario);
        $fornecedor = factory(Fornecedor::class)->create();
        $produtos = factory(Produto::class, 5)->create();

        $response = $this->get('/consultar-produtos?fornecedor='.$fornecedor->id);
        $content = $response->getOriginalContent()->getData();
        dd($content);
    }
}
