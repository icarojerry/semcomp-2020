<?php

namespace App\Http\Controllers;

use App\Artista;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $inicioDaRequisicao = Carbon::now();

        $itensPorPagina = 10;
        $paginaAtual = $request->input('pagina')?: 1;
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        $limit = $offset + $itensPorPagina;

        $artistas = Artista::getPagina($offset, $limit);
        $totalArtistas = Artista::total();

        $paginador = new LengthAwarePaginator($artistas, $totalArtistas, $itensPorPagina);
        $paginador->setPath($request->url());
        $paginador->appends(array('pagina' => $request->input('pagina')));

        if($limit != 0 && $paginaAtual > $paginador->lastPage())
        {
            abort(404);
        }

        $tempoExecucao = Carbon::now()->diffInMilliseconds($inicioDaRequisicao) / 1000;
        return view('artistas.index', compact('artistas'))->with('paginador', $paginador)->with('tempoExecucao', $tempoExecucao);
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
     * @param  \App\Artista  $artista
     * @return \Illuminate\Http\Response
     */
    public function show(Artista $artista)
    {
        //
    }
}
