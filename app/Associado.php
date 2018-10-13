<?php

namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Associado extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'public.associado';
    protected $primaryKey = 'new_as_cod';

}
