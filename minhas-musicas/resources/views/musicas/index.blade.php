@extends('layout')

@section('title', 'Músicas')

@section('content')
    <table class="table table-striped table-bordered table-hover">
        @if (!$musicas->count())
            <tr>
                <th>
                    <p>Não há músicas cadastrado na base.</p>
                </th>
            </tr>
        @else
            <thead>
            <tr>
                <th>Título</th>
                <th>Artista</th>
                <th>Gênero musical</th>
                <th>Visualizações</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-justify">
            @foreach ($musicas  as $musica)
                <tr>
                    <th scope="row">
                        {{ $musica->titulo }}
                    </th>
                    <th scope="row">
                        {{ $musica->artista->nome }}
                    </th>
                    <th scope="row">
                        {{ $musica->genero_musical }}
                    </th>
                    <th scope="row">
                        {{ number_format($musica->visualizacoes, 0, ',', '.') }}
                    </th>
                    <th>
                        <a class="btn btn-primary" href="{{ url("/musicas/$musica->id") }}">
                            <i class="fa fa-eye"></i> Ver
                        </a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        @endif
    </table>

    {!! $paginador->render() !!}
@endsection
