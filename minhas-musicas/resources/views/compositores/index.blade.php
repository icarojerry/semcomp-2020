@extends('layout')

@section('title', 'Compositores')

@section('content')
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            @if (!$compositores->count())
                <tr>
                    <th>
                        <p>Não há compositores cadastrado na base.</p>
                    </th>
                </tr>
            @else
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade de Músicas</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="text-justify">
                @foreach ($compositores  as $compositor)
                    <tr>
                        <th scope="row">
                            {{ $compositor->nome }}
                        </th>
                        <th scope="row">
                            0000
                        </th>
                        <th>
                            <a class="btn btn-primary" href="{{ url("/compositor/$compositor->id") }}">
                                <i class="fa fa-eye"></i> Ver
                            </a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
        {!! $paginador->render() !!}
    </div>

@endsection
