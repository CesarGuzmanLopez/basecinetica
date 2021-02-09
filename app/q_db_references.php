<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_reference
 * @property string $Reference
 * @property string $Coments
 * @property string $updated_at
 * @property string $created_at
 * @property QDbKOverall[] $qDbKOveralls
 * @property QDbPk[] $qDbPks
 */
class q_db_references extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_reference';

    /**
     * @var array
     */
    protected $fillable = ['Reference', 'Coments', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qDbKOveralls()
    {
        return $this->hasMany('App\QDbKOverall', 'id_reference', 'id_reference');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qDbPks()
    {
        return $this->hasMany('App\QDbPk', 'id_reference', 'id_reference');
    }
}
