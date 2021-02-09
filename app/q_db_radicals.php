<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_Radical
 * @property string $Name_Radical
 * @property string $Description
 * @property int $ID_Alta
 * @property User $user
 * @property QDbKOverall[] $qDbKOveralls
 */
class q_db_radicals extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_Radical';
    public $incrementing = true;
    
    /**
     * @var array
     */
    protected $fillable = ['Name_Radical', 'Description', 'ID_Alta'];

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
        return $this->hasMany('App\QDbKOverall', 'radical', 'ID_Radical');
    }
}
