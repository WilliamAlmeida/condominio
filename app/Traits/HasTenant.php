<?php

namespace App\Traits;

use App\Models\Tenant;

trait HasTenant
{
    protected $_tenant_colmun = 'tenant_id';

    public function scopeWithTenant($query, int $sameTenant = 1, int|Tenant $condominio = null)
    {
        $condominio = is_null($condominio) ? auth()->user()->condominios_id : (is_int($condominio) ? $condominio : $condominio->id);

        $column = $query->from.'.'.(isset($this->tenant_column) ? $this->tenant_column : $this->_tenant_colmun);

        return $query->where($column, ($sameTenant ? '=' : '!='), $condominio);
    }
}
