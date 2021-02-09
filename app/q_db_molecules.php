<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID
 * @property string $Name
 * @property string $RIS
 * @property string $SMILE
 * @property string $Imagen
 * @property string $Description
 * @property string $Active
 * @property QDbKOverall[] $qDbKOveralls
 * @property QDbPk[] $qDbPks
 */
class q_db_molecules extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['Name', 'RIS', 'SMILE', 'Imagen', 'Description', 'Active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qDbKOveralls()
    {
        return $this->hasMany('App\QDbKOverall', 'ID_Molecule', 'ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qDbPks()
    {
        return $this->hasMany('App\QDbPk', 'ID', 'ID');
    }
}
