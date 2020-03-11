<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    public static function urlExiste($url)
    {
        return Artista::where('url', $url)->count() > 0;
    }

    public function msuicas()
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
