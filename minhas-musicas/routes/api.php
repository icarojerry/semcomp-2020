<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('receberdados', function (Request $request)
{
    try
    {
        ;
        $payload = json_decode($request[0]? : $request->getContent(), true);
        if (!$payload || !$payload['url'])
        {
            return response("Arquivo não foi enviado corretamente.", 404);
        }

        if (\App\Artista::urlExiste($payload['url']))
        {
            return response("Já existe um artista com essa Url.", 409);
        }

        $artista = new \App\Artista();
        $artista->nome = $payload['name'];
        $artista->genero_musical = $payload['style'];
        $artista->visualizacoes = (int)$payload['views'];
        $artista->url = $payload['url'];
        $artista->save();

        $musicas = $payload['songs'];
        foreach ($musicas as $m)
        {
            if (\App\Musica::urlExiste($m['url']))
            {
                continue;
            }

            if ($m['language'] != "pt_br")
            {
                continue;
            }

            $musica = new \App\Musica();
            $musica->artista_id = $artista->id;
            $musica->url = $m['url'];
            $musica->titulo = $m['title'];
            $musica->visualizacoes = (int)$m['views'];
            $musica->genero_musical = $m['genre'];
            $musica->lingua = $m['language'];
            $musica->letra = \App\Musica::formatarLetra($m['lyric_pretty']);
            $musica->save();

            $compositores = $m['songwriters']? : [];
            foreach ($compositores as $c)
            {
                if (\App\Compositor::existe($c))
                {
                    continue;
                }
                $compositor = new \App\Compositor();
                $compositor->nome = $c;
                $musica->adicionarCompositor($compositor->toArray());
            }
        }
    } catch (\Exception $ex)
    {
        return response($ex->getMessage(), 500);
    }
    return response("Dados cadastrado com sucesso!", 200);
});
