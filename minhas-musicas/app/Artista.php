<?php

namespace App;

use Escavador\Vespa\Interfaces\AbstractDocument;
use Escavador\Vespa\Models\AbstractChild;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model  implements AbstractDocument
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

    /**
     * @inheritDoc
     */
    public function getVespaDocumentId () : string
    {
        // TODO: Implement getVespaDocumentId() method.
    }

    public function getVespaDocumentFields ()
    {
        // TODO: Implement getVespaDocumentFields() method.
    }

    public static function markAsVespaIndexed (array $document_ids)
    {
        // TODO: Implement markAsVespaIndexed() method.
    }

    public static function markAsVespaNotIndexed (array $document_ids)
    {
        // TODO: Implement markAsVespaNotIndexed() method.
    }

    public static function instanceByVespaChildResponse (AbstractChild $child) : AbstractDocument
    {
        // TODO: Implement instanceByVespaChildResponse() method.
    }

    public static function getVespaDocumentsToIndex (int $limit, array $document_ids = null)
    {
        // TODO: Implement getVespaDocumentsToIndex() method.
    }

    public static function getVespaDocumentIdsToIndex (int $limit)
    {
        // TODO: Implement getVespaDocumentIdsToIndex() method.
    }

    protected $hidden = [
        //
    ];

    protected $fillable = [
        'nome', 'genero_musical', 'visualizacoes', 'url',
    ];

    protected $table = "artistas";
}
