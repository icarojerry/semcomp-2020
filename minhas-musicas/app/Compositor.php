<?php

namespace App;

use Escavador\Vespa\Interfaces\AbstractDocument;
use Escavador\Vespa\Models\AbstractChild;
use Illuminate\Database\Eloquent\Model;

class Compositor extends Model implements AbstractDocument
{

    public static function total()
    {
        return Compositor::all()->count();
    }

    public static function getPagina($offset, $limit)
    {
        return Compositor::query()->offset($offset)->limit($limit)->orderBy('nome')->get();
    }

    public function musicas()
    {
        return $this->belongsToMany(Musica::class, 'musica_compositor');
    }

    public function adicionarMusica($musica)
    {
        $this->musicas()->create($musica);
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

    protected $fillable = [
        'nome'
    ];

    protected $table = 'compositores';
}
