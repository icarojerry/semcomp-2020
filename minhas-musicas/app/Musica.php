<?php

namespace App;

use Carbon\Carbon;
use Escavador\Vespa\Interfaces\AbstractDocument;
use Escavador\Vespa\Models\AbstractChild;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model implements AbstractDocument
{

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }

    public static function formatarLetra(array $letra)
    {
        return json_encode($letra, JSON_UNESCAPED_UNICODE);
    }

    public static function urlExiste($url)
    {
        return Musica::where('url', $url)->count() > 0;
    }

    public function adicionarCompositor($compositor)
    {
        $this->compositores()->create($compositor);
    }

    public function compositores()
    {
        return $this->belongsToMany(Compositor::class, 'musica_compositor');
    }

    //
    public function getVespaDocumentId ()
    {
        $this->id;
    }

    public function getVespaDocumentFields ()
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'letra' => $this->letra,
            'nome_em_citacoes' => $this->nome_em_citacoes,
            'url'  => $this->url,
            'updated_at' => date("Y-m-d H:i:s"),
            'timestamp' => time()
        ];
    }

    public static function markAsVespaIndexed($documents, array $indexes)
    {
        Musica::updateStatusVespa($documents, $indexes, EnumModelStatusVespa::INDEXED);
    }

    public static function markAsVespaNotIndexed($documents, array $indexes)
    {
        Musica::updateStatusVespa($documents, $indexes, EnumModelStatusVespa::NOT_INDEXED);
    }

    public static function instanceByVespaChildResponse (AbstractChild $child) : AbstractDocument
    {
        $id = $child->field('id');
        $titulo = $child->field('titulo');
        $letra = $child->field('letra');
        $url = $child->field('url');
        $visualizacoes = $child->field('visualizacoes');

        return new Musica($id, $titulo, $letra, $url, $visualizacoes);
    }

    public static function getVespaDocumentsToIndex (int $limit)
    {
        // TODO: Implement getVespaDocumentsToIndex() method.
    }

    private static function updateStatusVespa($documents, array $indexes, $statusVespa)
    {
        $ids = [];
        foreach ($indexes as $index)
        {
            $doc = $documents[$index];
            if (!in_array($doc->id, $ids)) {
                $ids[] = $doc->id;
            }
        }

        Musica::whereIn('id', $ids)
            ->update([
                config('vespa.model_columns.status') => $statusVespa,
                config('vespa.model_columns.date') => Carbon::now()
            ]);
    }

    protected $fillable = [
        'artista_id', 'compositor_id', 'titulo', 'letra', 'url', 'genero_musical', 'lingua', 'visualizacoes'
    ];

    protected $table = "musicas";
}
