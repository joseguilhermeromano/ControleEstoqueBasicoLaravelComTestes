<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

	protected $fillable = [
        'nome', 'descricao', 'preco', 'quantidade', 'fornecedor_id'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
}
