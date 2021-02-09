<?php
namespace App; 
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_app
 * @property string $Name_app
 * @property string $Version
 * @property string $Description
 * @property int $ID_Alta
 * @property string $updated_at
 * @property string $created_at
 * @property string $Location_name
 * @property boolean $Enable
 * @property User $user
 */
class desktop_apps extends Model
{
    protected $primaryKey = 'ID_app';
    
    public $incrementing = true;
    
    /**
     * @var array
     */
    protected $fillable = ['ID_app', 'Name_app', 'Version', 'Description', 'ID_Alta', 'updated_at', 'created_at', 'Location_name', 'Enable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'ID_Alta');
    }
}