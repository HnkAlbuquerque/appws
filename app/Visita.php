<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'public.ig_igreja_visita';
    const CREATED_AT = 'dtinserted';
}