<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_pks
 * @property int $id_reference
 * @property int $ID
 * @property string $Site
 * @property string $Tipo_Exp_teo
 * @property float $Value
 * @property int $ID_Alta
 * @property string $Description
 * @property User $user
 * @property QDbReference $qDbReference
 * @property QDbMolecule $qDbMolecule
 */
class q_db_pks extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_pks';

    /**
     * @var array
     */
    protected $fillable = ['id_reference', 'ID', 'Site', 'Tipo_Exp_teo', 'Value', 'ID_Alta', 'Description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'ID_Alta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qDbReference()
    {
        return $this->belongsTo('App\QDbReference', 'id_reference', 'id_reference');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qDbMolecule()
    {
        return $this->belongsTo('App\QDbMolecule', 'ID', 'ID');
    }
}
