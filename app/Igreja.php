<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
{
    protected $table = 'public.ig_igreja';
    const CREATED_AT = 'igr_dt_insert';
    const UPDATED_AT = 'dt_atualizado';
    protected $primaryKey = 'igr_id';
}