<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsuariosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */

    public function verificar_se_o_administrador_pode_listar_todos_os_usuarios() {
        $usuario = factory(User::class)->create(['tipo' => 'admin']);
        
        Auth::login($usuario);
        $response = $this->get('/usuarios');
        
        $response->assertSee($usuario->name);
        $response->assertSee($usuario->email);
        $response->assertSee($usuario->tipo);
        $response->assertSee($usuario->status);
    }

    /** @test */

    public function usuario_comum_nao_pode_listar_todos_os_usuarios() {
        $usuario = factory(User::class)->create(["tipo" => "comum"]);
        
        Auth::login($usuario);
        $response = $this->get('/usuarios');
        $response->assertStatus(403);
    }
    
    /** @test */

    public function administrador_pode_cadastrar_usuarios() {
        $admin = factory(User::class)->create(['tipo' => 'admin']);
        $usuario = factory(User::class)->make(["password" => "teste123"]);

        Auth::login($admin);
        $response = $this->post('/cadastrar-usuario', [
                'name' => $usuario->name,
                'email' => $usuario->email,
                'tipo' => $usuario->tipo,
                'password' => $usuario->password
            ]);
        
        $response->assertSee($usuario->name);
        $response->assertSee($usuario->email);
        $response->assertSee($usuario->tipo);
        $response->assertSee($usuario->status);
    }

    /** @test */

    public function usuario_comum_nao_pode_cadastrar_usuarios() {
        $usuario = factory(User::class)->create(["tipo" => 'comum']);
        
        Auth::login($usuario);
        $response = $this->post('/cadastrar-usuario', [
                'name' => $usuario->name,
                'email' => $usuario->email,
                'tipo' => $usuario->tipo,
                'password' => $usuario->password
            ]);

        $response->assertStatus(403);
    }

    /** @test */

    public function administrador_pode_desativar_usuarios() {
        $admin = factory(User::class)->create(["tipo" => "admin"]);        
        Auth::login($admin);

        $usuario = factory(User::class)->create();

        $response = $this->post('/desativar-usuario/'.$usuario->id, [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'password' => $usuario->password,
            'status' => $usuario->status
        ]);

        $usuario = User::find($usuario->id);
        $response->assertStatus(200);
        $this->assertEquals($usuario->status, "inativo");
        $response->assertSee($usuario->name);
        $response->assertSee($usuario->email);
        $response->assertSee("O Usuário foi desativado com sucesso!");
    }

    /** @test */

    public function administrador_pode_ativar_usuarios() {
        $admin = factory(User::class)->create(["tipo" => "admin"]);        
        Auth::login($admin);

        $usuario = factory(User::class)->create();

        $response = $this->post('/ativar-usuario/'.$usuario->id, [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'password' => $usuario->password,
            'status' => $usuario->status
        ]);

        $usuario = User::find($usuario->id);
        $response->assertStatus(200);
        $this->assertEquals($usuario->status, "ativo");
        $response->assertSee($usuario->name);
        $response->assertSee($usuario->email);
        $response->assertSee("O Usuário foi ativado com sucesso!");
    }

    /** @test */

    public function usuario_comum_nao_pode_alterar_usuarios() {
        $admin = factory(User::class)->create(["tipo" => "comum"]);        
        Auth::login($admin);

        $usuario = factory(User::class)->create();

        $response = $this->post('/alterar-usuario/'.$usuario->id, [
            'name' => "teste",
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'password' => $usuario->password,
            'status' => $usuario->status
        ]);

        $usuario = User::find($usuario->id);
        $response->assertStatus(403);
    }

    /** @test */

    public function usuario_admin_pode_alterar_usuarios() {
        $admin = factory(User::class)->create(["tipo" => "admin"]);        
        Auth::login($admin);

        $usuario = factory(User::class)->create();

        $response = $this->post('/alterar-usuario/'.$usuario->id, [
            'name' => "teste",
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'password' => $usuario->password,
            'status' => "inativo"
        ]);

        $usuario = User::find($usuario->id);
        $response->assertStatus(200);
        $this->assertEquals($usuario->name, "teste");
        $this->assertEquals($usuario->status, "inativo");
    }

    /** @test */

    public function usuario_admin_pode_consultar_usuarios(){
        $admin = factory(User::class)->create(['tipo' => 'admin']);        
        Auth::login($admin);
        $usuario = factory(User::class)->create(['name' => 'fernando']);

        $response = $this->post('/cadastrar-usuario', [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'status' => $usuario->status
        ]);

        $usuario = User::find($usuario->id);

        $response = $this->get('/consultar-usuarios?busca=fernando');
        $response->assertStatus(200);
        $response->assertSee($usuario->name);
        $response->assertSee($usuario->email);
        $response->assertSee($usuario->tipo);
        $response->assertSee($usuario->status);
    }
}
