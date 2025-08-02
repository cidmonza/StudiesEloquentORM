<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesteModel extends Model
{
    // se quiser definir qual é a tabela do model:
    protected $table = 'products';

    // definir a chave primária, caso necessário (não se chamar apenas id)
    protected $primaryKey = 'id';

    // se não tiver auto incremento
    public $incrementing = false;

    // se for uma string, por exemplo
    protected $keyType = 'string';

    // se n tiver timestamps
    public $timestamps = false;

    // se for necessário alterar o formato da data
    //  exemplo unix
    //protected $dateFormat = 'U';

    // exemplo standard
    protected $dateFormat = 'Y-m-d H:i:s';

    // se os timestamps tiverem outro nome no db:

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualização';

    // direcionar qual coleção (db) será utilizado

    protected $connection = 'mysql_new';
}
