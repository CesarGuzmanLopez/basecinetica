<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $Name
 * @property string $prefix
 * @property string $Description
 */
class data_bases_q_s extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['Name', 'prefix', 'Description'];

}
