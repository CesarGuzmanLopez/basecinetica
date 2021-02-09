<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $radical
 * @property int $id_reference
 * @property int $ID_K_OVERALL
 * @property int $ID_Molecule
 * @property int $Solvent
 * @property float $Valor
 * @property float $pH
 * @property string $Tipo
 * @property string $Descripcion
 * @property int $ID_Alta
 * @property string $updated_at
 * @property string $created_at
 * @property QDbRadical $qDbRadical
 * @property QDbSolvent $qDbSolvent
 * @property User $user
 * @property QDbReference $qDbReference
 * @property QDbMolecule $qDbMolecule
 */
class q_db_k_overalls extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_K_OVERALL';

    public $incrementing = true;
    
    /**
     * @var array
     */
    protected $fillable = ['radical', 'id_reference', 'ID_Molecule', 'Solvent', 'Valor', 'pH', 'Tipo', 'Descripcion', 'ID_Alta', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qDbRadical()
    {
        return $this->belongsTo('App\q_db_Radicals', 'radical', 'ID_Radical');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qDbSolvent()
    {
        return $this->belongsTo('App\q_db_Solvents', 'Solvent', 'ID_Solvent');
    }

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
        return $this->belongsTo('App\q_db_Molecules', 'ID_Molecule', 'ID');
    }
}
