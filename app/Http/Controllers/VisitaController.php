<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Visita;
use App\Associado;
use App\Igreja;
use DB;

class VisitaController extends Controller
{
    private $visita;
    private $request;
    private $associado;
    private $igreja;

    public function __construct(Request $request, Visita $visita, Associado $associado, Igreja $igreja)
    {
        $this->visita = $visita;
        $this->request = $request;
        $this->associado = $associado;
        $this->igreja = $igreja;
    }

    public function insert()
    {

            $saveVisita = false;

            $visita = $this->visita;
            $visita->campoid = current(explode(' ',$this->request->json('campoid')));
            $visita->igrejaid = current(explode(' ',$this->request->json('igrejaid')));
            $visita->associadoid = current(explode(' ',$this->request->json('associadoid')));
            $visita->oracao = current(explode(' ',$this->request->json('oracao')));

            $visita->data = ($this->request->json('data')) ? $this->request->json('data') : null ;
            $visita->dt_proxima = ($this->request->json('dt_proxima')) ? $this->request->json('dt_proxima') : null ;
            $visita->dt_avaliacao = ($this->request->json('dt_avaliacao')) ? $this->request->json('dt_proxima') : null ;

            $visita->oferta = preg_replace('/\D/', '', $this->request->json('oferta'));

            $visita->tipo_culto = $this->request->json('tipo_culto');
            $visita->multimedia = $this->request->json('multimedia');
            $visita->tempo_mensagem = $this->request->json('tempo_mensagem');
            $visita->carta = $this->request->json('carta');
            $visita->avaliacao = $this->request->json('avaliacao');
            $visita->obs = $this->request->json('obs');

            try {
                $saveVisita = $visita->save();
            }
            catch (QueryException $exception) {

            }

            return response()->json($saveVisita);

    }

    public function igrejaInsert()
    {

        $saveIgreja = false;

        $igreja = $this->igreja;

      //  dd($this->request->get('cep'));

        $igreja->deno_cod = current(explode(' ',$this->request->json('denoid')));
        $igreja->cmp_cod = current(explode(' ',$this->request->json('campoid')));
        $igreja->idassociado = current(explode(' ',$this->request->json('associadoid')));
        $igreja->login = $this->request->json('login');
        $igreja->igr_nome = $this->request->json('igr_nome');
        $igreja->end_igr_res_nome = $this->request->json('endereco');
        $igreja->end_igr_res_num = $this->request->json('num');
        $igreja->end_igr_res_comp = $this->request->json('compl');
        $igreja->end_igr_res_bairro = $this->request->json('bairro');
        $igreja->end_igr_res_cidade = $this->request->json('cidade');
        $igreja->end_igr_res_estado = $this->request->json('estado');
        $igreja->end_igr_res_cep = $this->request->json('cep');
        $igreja->igr_cnpj = $this->request->json('cnpj');
        $igreja->pas_nome = $this->request->json('pastor');
        $igreja->pas_tel_fixo = $this->request->json('telpastor');
        $igreja->pas_tel_fixo = $this->request->json('telpastor');
        $igreja->igr_status_id = 1;


        try {
            $saveIgreja = $igreja->save();
        }
        catch (QueryException $exception) {

        }

        return response()->json($saveIgreja);

    }




}
