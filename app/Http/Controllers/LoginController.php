<?php

namespace App\Http\Controllers;

use App\Associado;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(Request $request, Associado $associado)
    {
        $this->request = $request;
        $this->associado = $associado;
    }

    public function index()
    {
        $obj = $this->request->json()->all();
        //$obj = $this->request->all();

        $pass = 'false';

        $obj['as_cpf'] = preg_replace('/\D/', '', $obj['as_cpf']);

        $user = $this->associado->select('as_cpf','as_nome','as_tipo','password',
            DB::raw("LPAD(new_as_cod::text, 7, '0') as new_as_cod"),
            DB::raw("g.id || ' - ' || g.nome as campo"),
            DB::raw("new_as_cod || ' - ' || as_nome as fullassociado"),
            DB::raw("to_char(as_dt_adm,'DD/MM/YYYY') as dt_admin")
        )
                     ->where('as_cpf','=',$obj['as_cpf'])
                     ->join('geo.campo as g','g.id','=','associado.cmp_cod')
                     ->whereIn('mot_cod',[1,6,7,8])
                     ->first();

        if($user) {
            if(empty($user->password)){
                $user->password = Hash::make($obj['password']);
                $user->save();
            }
        }

        if (Auth::attempt(['as_cpf' =>  $obj['as_cpf'], 'password' => $obj['password'], 'bloqueado' => false])) {

                $pass = ['pass' => 'true','as_cpf' => $user->as_cpf,
                         'new_as_cod' => $user->new_as_cod,'as_nome' => $user->as_nome,
                         'as_cod' => $user->as_cod, 'as_tipo' => $user->as_tipo,'password' => $user->password,
                         'campo' => $user->campo, 'fullassociado' => $user->fullassociado, 'dt_admin' => $user->dt_admin];
        }

        return response()->json($pass);
    }

    public function revalLogin()
    {
        $obj = $this->request->json()->all();

        $pass = 'false';

        $obj['as_cpf'] = preg_replace('/\D/', '', $obj['as_cpf']);

        $user = $this->associado->select('as_cpf','as_nome','as_tipo','password',
            DB::raw("LPAD(new_as_cod::text, 7, '0') as new_as_cod"),
            DB::raw("g.id || ' - ' || g.nome as campo"),
            DB::raw("new_as_cod || ' - ' || as_nome as fullassociado"),
            DB::raw("to_char(as_dt_adm,'DD/MM/YYYY') as dt_admin")
        )
            ->where('as_cpf','=',$obj['as_cpf'])
           // ->where('new_as_cod','=',$obj['new_as_cod'])
            ->join('geo.campo as g','g.id','=','associado.cmp_cod')
            ->whereIn('mot_cod',[1,6,7,8])
            ->first();


        $pass = ['pass' => 'true','as_cpf' => $user->as_cpf,
            'new_as_cod' => $user->new_as_cod,'as_nome' => $user->as_nome,
            'as_cod' => $user->as_cod, 'as_tipo' => $user->as_tipo,'password' => $user->password,
            'campo' => $user->campo, 'fullassociado' => $user->fullassociado, 'dt_admin' => $user->dt_admin];


        return response()->json($pass);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
