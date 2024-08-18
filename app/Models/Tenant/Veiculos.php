<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Veiculos extends Model
{
	protected $primaryKey = 'id';

    use BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'placa', 'marca', 'modelo', 'cor', 'ano', 'foto_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
    ];

    public function condominios()
    {
        return $this->hasOne('App\Models\Tenant','id','tenant_id');
    }

    public function getPlacaFormatAttribute()
    {
        return strtoupper(substr($this->placa, 0, 3) . '-' . substr($this->placa, 3, 4));
    }
}