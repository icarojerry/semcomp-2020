@extends('layout')

@section('title', 'Página Inicial')

@section('content')
    <div class="container">
        <h1 class="title"><b>minhasmusicas</b>.com</h1>
        <h2 class="sub-title">aqui você encontra a música que tanto procura</h2>

        <div class="search-container">
            <form class="search-form" action="{{url('/search')}}">
                <input type="text" placeholder="pesquise uma letra, um artista, uma banda, um compositor..." name="search">
                <button type="submit"><b>buscar</b></button>
            </form>
        </div>

        <hr/>
        <div class="sub-title">
            {{ $artistas }} artista{{ $artistas != 1 ? 's' : '' }}
            | {{ $musicas }} música{{ $musicas != 1 ? 's' : '' }}
            | {{ $compositores }} compositor{{ $compositores !=1 ? 'es' : '' }}
        </div>
    </div>
@endsection
