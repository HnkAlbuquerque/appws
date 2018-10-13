<?php

namespace App\Http\Controllers;

use App\InstContato;
use App\Local;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Distribuicao;
use App\DistribuicaoDetail;
use App\Nttipo;
use DB;

class DistribuicaoController extends Controller
{
    private $request;
    public $distribuicao;
    public $distribuicaoDetail;
    public $nttipo;
    private $local;
    private $insContato;

    public function __construct(Request $request, Distribuicao $distribuicao, DistribuicaoDetail $distribuicaoDetail, Nttipo $nttipo, Local $local, InstContato $instContato)
    {
        $this->request = $request;
        $this->distribuicao = $distribuicao;
        $this->distribuicaoDetail = $distribuicaoDetail;
        $this->nttipo = $nttipo;
        $this->local = $local;
        $this->insContato = $instContato;

    }

    public function insert()
    {
        $saveDist = false;
        $saveDetail = false;

        $singleDist = $this->distribuicao;
        $singleDist->data = ($this->request->json('data')) ? $this->request->json('data') : null ;
        $singleDist->idinstituicao = current(explode(' ', $this->request->json('idinstituicao')));
        $singleDist->idassociado = current(explode(' ', $this->request->json('idassociado')));
        $singleDist->proximadata = ($this->request->json('proximadata')) ? $this->request->json('proximadata') : null ;
        $singleDist->contato = $this->request->json('contato');
        $singleDist->obs = $this->request->json('obs');
        $singleDist->turno = $this->request->json('turno');
        $singleDist->idcampo = current(explode(' ', $this->request->json('idcampo')));


        try
        {
            $saveDist = $singleDist->save();

        }
        catch (QueryException $exception)
        {

        }

      if($saveDist)
        {
            $array = array("azulbolso_".$this->request->json('azulbolso'),
                            "azulmesa_".$this->request->json('azulmesa'),
                            "branco_".$this->request->json('branco'),
                            "bilingue_".$this->request->json('bilingue'),
                            "trilingue_".$this->request->json('trilingue'),
                            "exercito_".$this->request->json('exercito'),
                            "aeronautica_".$this->request->json('aeronautica'),
                            "marinha_".$this->request->json('marinha'));

            for($i=0; $i < count($array);$i++)
            {
                    $arrayPiece = explode('_',$array[$i]);

                    if(isset($arrayPiece[1]) and $arrayPiece[1] > 0 )
                    {
                        $findNtid = $this->nttipo->where('nt_ionicdesc','=',$arrayPiece[0])->first();
                        $arrayInsertDetail[] = array('distribuicaoid' => $singleDist->id, 'ntid' => $findNtid->id, 'quantidade' => $arrayPiece[1]);
                    }
            }

            try{
                $saveDetail = $this->distribuicaoDetail->insert($arrayInsertDetail);
            }
            catch (QueryException $exception) {

            }

        }

        return response()->json($saveDetail);

    }

    public function localInsert()
    {
        $saveLocal = false;

        $local = $this->local;
        $instContato = $this->insContato;

        $local->nome = $this->request->json('nome');
        $local->cnpj = preg_replace('/\D/', '', $this->request->json('cnpj'));
        $local->idtipoinst = $this->request->json('tipoinst');
        $local->idcampo = current(explode(' ',$this->request->json('campoid')));
        $local->idassociado = current(explode(' ',$this->request->json('associadoid')));
        $local->endereco = $this->request->json('endereco');
        $local->complemento = $this->request->json('compl');
        $local->bairro = $this->request->json('bairro');
        $local->cidade = $this->request->json('cidade');
        $local->uf = $this->request->json('estado');
        $local->cep = $this->request->json('cep');
        $local->num = $this->request->json('num');

        try {
            $saveLocal = $local->save();
        }
        catch (QueryException $exception) {

        }

        $instContato->idinstituicao = $local->id;
        $instContato->telefone = $this->request->json('pessoatel');
        $instContato->contato = $this->request->json('pessoa');

        try {
            $instContato->save();
        }
        catch (QueryException $exception) {

        }

        return response()->json($saveLocal);

    }
}
