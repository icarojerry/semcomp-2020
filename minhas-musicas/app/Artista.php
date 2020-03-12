<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    public static function urlExiste($url)
    {
        return Artista::where('url', $url)->count() > 0;
    }

    public static function getPagina($offset, $limit)
    {
        return Artista::query()->offset($offset)->limit($limit)->orderByDesc('visualizacoes')->get();
    }

    public static function total()
    {
        return Artista::all()->count();
    }

    public function musicas()
    {
        return $this->hasMany(Musica::class);
    }

    protected $hidden = [
        //
    ];

    protected $fillable = [
        'nome', 'genero_musical', 'visualizacoes', 'url',
    ];

    protected $table = "artistas";
}
