<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Enderecos extends Model
{
	protected $primaryKey = 'id';

    use BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'cep', 'rua', 'numero', 'bairro', 'complemento', 'cidade_id', 'estado_id'
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

    public function cidade()
    {
        return $this->hasOne('App\Models\Cidade','id','cidade_id');
    }

    public function estado()
    {
        return $this->hasOne('App\Models\Estado','id','estado_id');
    }
}