<?php

namespace App;

use Carbon\Carbon;
use Escavador\Vespa\Interfaces\AbstractDocument;
use Escavador\Vespa\Models\AbstractChild;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model implements AbstractDocument
{

    public static function total()
    {
        return Musica::all()->count();
    }

    public static function getPagina($offset, $limit)
    {
        return Musica::query()->offset($offset)->limit($limit)->orderByDesc('visualizacoes')->get();
    }

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

    public function adicionarCompositor(Compositor $compositor)
    {
        $this->compositores()->attach($compositor->id);
    }

    public function compositores()
    {
        return $this->belongsToMany(Compositor::class, 'musica_compositor');
    }

    public function getVespaDocumentId () : string
    {
        return (string) $this->id;
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

    public static function markAsVespaIndexed(array $document_ids)
    {
        Musica::updateStatusVespa($document_ids, EnumModelStatusVespa::INDEXED);
    }

    public static function markAsVespaNotIndexed(array $document_ids)
    {
        Musica::updateStatusVespa($document_ids, EnumModelStatusVespa::NOT_INDEXED);
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

    public static function getVespaDocumentIdsToIndex(int $limit)
    {
        // TODO: Implement getVespaDocumentsToIndex() method.
    }

    public static function getVespaDocumentsToIndex (int $limit, array $document_ids = null)
    {
        // TODO: Implement getVespaDocumentsToIndex() method.
    }

    private static function updateStatusVespa(array $document_ids, $statusVespa)
    {
        if(count($document_ids) == 0)
        {
            return;
        }
        Musica::whereIn('id', $document_ids)
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
