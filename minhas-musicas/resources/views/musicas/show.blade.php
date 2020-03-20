@extends('layout')

@section('title', 'Músicas')

@section('content')
    <div class="container">
        <h2 class="title">
            {{$musica->titulo}}
        </h2>
        <h4 class="sub-title">
            {{ $musica->artista->nome }}
        </h4>
        <h6 class="sub-title">
            {{ $musica->genero_musical }} - <i class="fa fa-eye"></i> {{ number_format($musica->visualizacoes, 0, ',', '.') }}
        </h6>

        <div class="container letra">
            @foreach($musica->letraFormatada() as $estrofe)
                <div class="estrofe">
                    @foreach($estrofe as $verso)
                        <p>
                            {{ $verso }}
                        </p>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="container">
            <p>
                Compositor: {{ $musica->compositor }}
            </p>
            <p>
                Música Original <a href="{{ $musica->url }}">aqui</a>.
            </p>
        </div>

    </div>

@endsection
