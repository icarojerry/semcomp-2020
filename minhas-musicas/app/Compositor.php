<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compositor extends Model
{

    public function musicas()
    {
        return $this->belongsToMany(Musica::class, 'musica_compositor');
    }

    public function adicionarMusica($musica)
    {
        $this->musicas()->create($musica);
    }

    protected $fillable = [
        'nome'
    ];

    protected $table = 'compositores';
}
