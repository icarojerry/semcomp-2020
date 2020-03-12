@extends('layout')

@section('title', 'Artistas')

@section('content')
    <table class="table table-striped table-bordered table-hover">
        @if (!$artistas->count())
            <tr>
                <th>
                    <p>Não há artistas cadastrado na base.</p>
                </th>
            </tr>
        @else
            <thead>
            <tr>
                <th>Nome</th>
                <th>Gênero musical</th>
                <th>Músicas</th>
                <th>Visualizações</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-justify">
            @foreach ($artistas  as $artista)
                <tr>
                    <th scope="row">
                        {{ $artista->nome }}
                    </th>
                    <th scope="row">
                        {{ $artista->genero_musical }}
                    </th>
                    <th scope="row">
                        {{ count($artista->musicas) }}
                    </th>
                    <th scope="row">
                        {{ number_format($artista->visualizacoes, 0, ',', '.') }}
                    </th>
                    <th>
                        <a class="btn btn-primary" href="{{ url("/artistas/$artista->id") }}">
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
