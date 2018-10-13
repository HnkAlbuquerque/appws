<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstContato extends Model
{
    protected $table = 'instituicao.instituicao_contato';
    public $timestamps = false;
    protected $primaryKey = 'idinstituicao';
}
