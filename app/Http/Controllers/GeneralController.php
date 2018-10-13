<?php

namespace App\Http\Controllers;

use App\Notifications\CalendarioOracao;
use Illuminate\Http\Request;
use App\Http\OneSignal;
use DB;
use Illuminate\Support\Facades\Notification;

class GeneralController extends Controller
{
    //
    public function getCampos($param)
    {
        $parametro = str_replace(' ','%',$param);

        $array = DB::table('geo.campo')->select(DB::raw('lpad(trim(to_char(id,\'9999999\')),3,\'0\') as id'),DB::raw('trim(nome) as nome'),'ativo')
            ->where('ativo','=','true')
            ->where('dtinstalacao','>','1900-01-01');

        if($param > 0) {
            $array =  $array->where('id','=',$parametro);
        }
        else{
            $array =  $array->where('nome','ilike','%'.$parametro.'%');
        }

        $array =  $array->orderBy('nome','ASC')->get();

        return response()->json($array);
    }

    public function getTiposLocais()
    {
        $array = DB::table('instituicao.tipoinstituicao')->select(DB::raw('trim(to_char(id,\'9999999\')) as id'),'descricao','id as idint')
            ->where('id','>',1)
            ->orderBy('idint','ASC')->get();
        return response()->json($array);
    }

    public function getLocais($tipoInstituicao,$idcampo)
    {
        $array = DB::table('instituicao.instituicao')->select(DB::raw('trim(to_char(id,\'999999999999\')) as idstr'),'nome','id')
            ->where('idtipoinst','=',$tipoInstituicao)
            ->where('idcampo','=',$idcampo)
            ->where('ativo','=',true)
            ->orderBy('nome','ASC')->get();
        return response()->json($array);
    }

    public function getMembros($param)
    {

        $parametro = str_replace(' ','%',$param);

        $array = DB::table('public.associado')->select('new_as_cod','as_nome')
                    ->whereIn('mot_cod',[1,6,7,8]);

        if($param > 0) {
            $array =  $array->where('new_as_cod','like','%'.$parametro.'%');
        }
        else{
            $array =  $array->where('as_nome','ilike','%'.$parametro.'%');
        }

       $array =  $array->orderBy('as_tipo','DESC')
        ->orderBy('as_nome','ASC')
        ->get();

        return response()->json($array);
    }

    public function getIgrejas($idcampo)
    {

        $array = DB::table('public.ig_igreja')->select(DB::raw('trim(to_char(igr_id,\'999999999999\')) as idstr'),'igr_nome','igr_id')
            ->where('cmp_cod','=',$idcampo)
            ->where('igr_status_id','=',1)
            ->orderBy('igr_nome','ASC')->get();

        return response()->json($array);
    }

    public function getGideao($param)
    {

        $parametro = str_replace(' ','%',$param);

        $array = DB::table('public.associado')->select('new_as_cod','as_nome')
            ->whereIn('mot_cod',[1,6,7,8])
            ->where('as_tipo','=','G');

        if($param > 0) {
            $array =  $array->where('new_as_cod','like','%'.$parametro.'%');
        }
        else{
            $array =  $array->where('as_nome','ilike','%'.$parametro.'%');
        }

        $array =  $array->orderBy('as_tipo','DESC')
            ->orderBy('as_nome','ASC')
            ->get();

        return response()->json($array);
    }

    public function getDates()
    {
        $array[0][0] = 'datainicio';
        $array[0][1] = date('Y-m-d');

        dd($array);
    }

    public function getFeed()
    {
        $result = DB::table('public.appfeed')->select('*')->where('active','=',true)->orderBy('created_at','desc')->limit(5)->get();
        $array = array();

        return $result;
    }

    public function getNttipo($new_as_cod)
    {

        $array = DB::table('public.nt_tipo')->select(DB::raw('trim(to_char(id,\'999999999999\')) as idstr'),'id','dist','nt_newdesc','nt_ionicdesc');

        if(substr($new_as_cod, 0, 2) == 0) {
            $array = $array->where('dist','=',true)->where('tp_cod_gid','>',0);
        }
        else{
            $array = $array->where('dist','=',true)->where('tp_cod_aux','>',0);
        }

        $array = $array->orderBy('id','ASC')->get();

        return response()->json($array);

    }

    public function getDeno()
    {

        $array = DB::table('public.denominacao')->select(DB::raw('trim(to_char(deno_cod,\'999999999999\')) as denostr'),'deno_cod','deno_descr')
            ->where('ativa','=',true)
            ->where('deno_cod','<>',18)
            ->orderBy('deno_descr','asc')
            ->get();
        return response()->json($array);
    }

    public function getCalendarDay()
    {
        $day = date('d');
       // dd($day);

        $array = DB::table('public.cal_oracao')->select('*',DB::raw("coalesce(length(imagem),0) as img"))
            ->where('dia','=',$day)
            ->where('ativo','=',true)
            ->get();

        return response()->json($array);
    }

    public function teste()
    {
        $data = ["nome" => 'hnk', "idade" => 19];
        $user = DB::table('sitenewlogs.player_id')->select('player_id')->get();
      //  dd($user);
        Notification::send($user, new CalendarioOracao($data));

    }



}
