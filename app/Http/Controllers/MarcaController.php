<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    protected $marca;
   
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $marcaRepository new MarcaRepository();
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $marcas =  array();
       
        if($request->has('atributos_marca')) {
            $atributos_modelos = $request->atributos_marca;
            $marcas = $this->marca->with('modelos:id, '.$atributos_modelos);
        } else {
            $marcas = $this->marca->with('modelos');
        }

        if($request->has('filtro')) {
            $filtros =  explode(':', $request->filtro);
            foreach($filtros as $key =>$condicao) {
                $c =  explode(':', $condicao);
                $marcas = $marcas->where($c[0], $c[1], $c[2]);

            }
        }

        if($request->has('atributos')) {
            $atributos = $request->atributos;
            $marcas = $marcas->selectRaw($atributos)->get();
        } else {
            $marcas = $marcas->get();
        }

        //$marca = $this->marca->with('modelos')->get();
        return response()->json($marcas, 200);

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
        $request->validate($this->marca->rules(), $this->marca->feedback());
        
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca = $this->marca->create([
                'nome' => $request->nome,
                'imagem' => $imagem_urn
        ]);   
        
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if($marca == null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        } 
        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $marca = $this->marca->find($id);

        if($marca == null) {
                return response()->json(['erro' => 'Impossivel realizar a atualiazção. O recurso solicitado não existe!'], 404);
        }

        if($request->method() == 'PATCH') {
                $regrasDinamicas = array();
                //percorrendo todas as regras definidas no model
                foreach($marca->rules() as $input => $regra) {
                        //coletar apenas as regras aplcaiveis aos paramentros parciais da requisição PATCH
                        if(array_key_exists($input, $request->all())) {
                                $regrasDinamicas[$input] = $regra;
                        }
                }

                $request->validate($marca->rules(), $marca->feedback());
        } else {
                $request->validate($marca->rules(), $marca->feedback());
        }

        if($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
        }

        $imagem =  $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        //preencher o objeto $marca com os dados do request
        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

        /*$marca->update([
                'nome' => $request->nome,
                'imagem' => $imagem_urn
        ]);*/

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
        $marca = $this->marca->find($id);

        if($marca == null) {
                return response()->json(['erro' => 'Impossivel realizar a atualiazção. O recurso solicitado não existe!'], 404);
        }

       
        Storage::disk('public')->delete($marca->imagem);
    

        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
