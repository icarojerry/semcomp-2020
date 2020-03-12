<?php

namespace App\Http\Controllers;

use App\Artista;
use App\Compositor;
use App\Musica;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomePageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $inicioDaRequisicao = Carbon::now();

        $artistas =  number_format(Artista::total(), 0, ',', '.');
        $musicas = number_format(Musica::total(), 0, ',', '.');;
        $compositores = number_format(Compositor::total(), 0, ',', '.');

        $tempoExecucao = Carbon::now()->diffInMilliseconds($inicioDaRequisicao) / 1000;
        return view('home')->with('artistas', $artistas)
            ->with('musicas', $musicas)
            ->with('compositores', $compositores)
            ->with('tempoExecucao', $tempoExecucao);
    }
}
