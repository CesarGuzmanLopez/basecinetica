<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_Solvent
 * @property string $Name_Solvent
 * @property string $Description
 * @property int $ID_Alta
 * @property string $updated_at
 * @property string $created_at
 * @property User $user
 * @property QDbKOverall[] $qDbKOveralls
 */
class q_db_solvents extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_Solvent';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    
    /**
     * @var array
     */
    protected $fillable = ['Name_Solvent', 'Description', 'ID_Alta', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'ID_Alta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qDbKOveralls()
    {
        return $this->hasMany('App\QDbKOverall', 'Solvent', 'ID_Solvent');
    }
}
