<?php

namespace App\Http\Controllers;

use App\Compositor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CompositorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inicioDaRequisicao = Carbon::now();

        $itensPorPagina = 10;
        $paginaAtual = $request->input('pagina')?: 1;
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        $limit = $offset + $itensPorPagina;

        $compositores = Compositor::getPagina($offset, $limit);
        $totalCompositores = Compositor::total();

        $paginador = new LengthAwarePaginator($compositores, $totalCompositores, $itensPorPagina);
        $paginador->setPath($request->url());
        $paginador->appends(array('pagina' => $request->input('pagina')));

        if($limit != 0 && $paginaAtual > $paginador->lastPage())
        {
            abort(404);
        }

        $tempoExecucao = Carbon::now()->diffInMilliseconds($inicioDaRequisicao) / 1000;
        return view('compositores.index', compact('compositores'))->with('paginador', $paginador)->with('tempoExecucao', $tempoExecucao);
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
     * @param  \App\Compositor  $compositor
     * @return \Illuminate\Http\Response
     */
    public function show(Compositor $compositor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compositor  $compositor
     * @return \Illuminate\Http\Response
     */
    public function edit(Compositor $compositor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compositor  $compositor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compositor $compositor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compositor  $compositor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compositor $compositor)
    {
        //
    }
}
