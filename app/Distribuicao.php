<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribuicao extends Model
{
    protected $table = 'instituicao.distribuicao';
    const CREATED_AT = 'dt_lancto';
}
