<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
	use SoftDeletes;

    protected $table = "fornecedores";
    protected $fillable = [
        'nome', 'endereco', 'cnpj'
    ];

    protected $dates = ['deleted_at'];

}
