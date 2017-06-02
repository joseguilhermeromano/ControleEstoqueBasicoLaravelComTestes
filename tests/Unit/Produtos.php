<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Fornecedor;
use App\Produto;

class Produtos extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function um_produto_possui_um_fornecedor()
    {
        $produto = factory(Produto::class)->create();

        $this->assertInstanceOf(Fornecedor::class, $produto->fornecedor);
    }

}
