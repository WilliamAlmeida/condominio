<?php

namespace App\Models\Tenant;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EmpresasServicos extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'empresas_servicos';

    use BelongsToTenant;
    use HasTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'categoria', 'cnpj', 'razao_social', 'nome_fantasia', 'inscricao_estadual', 'inscricao_municipal', 'telefone_1', 'telefone_2', 'whatsapp', 'email', 'site', 'endereco_id', 'foto_id', 'descricao'
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

    public function foto()
    {
        return $this->hasOne('App\Models\Tenant\Fotos','id','foto_id');
    }

    public function endereco()
    {
        return $this->hasOne('App\Models\Tenant\Enderecos','id','endereco_id');
    }

    public function prestadores()
    {
        return $this->hasMany('App\Models\Tenant\PrestadoresServicos','empresa_id','id');
    }

    public function getTelefone1FormatAttribute()
    {
        return $this->telefone_1 ? '(' . substr($this->telefone_1, 0, 2) . ') ' . substr($this->telefone_1, 2, 5) . '-' . substr($this->telefone_1, 7) : '';
    }

    public function getTelefone2FormatAttribute()
    {
        return $this->telefone_2 ? '(' . substr($this->telefone_2, 0, 2) . ') ' . substr($this->telefone_2, 2, 5) . '-' . substr($this->telefone_2, 7) : '';
    }

    public function getWhatsappFormatAttribute()
    {
        return $this->whatsapp ? '(' . substr($this->whatsapp, 0, 2) . ') ' . substr($this->whatsapp, 2, 5) . '-' . substr($this->whatsapp, 7) : '';
    }

    public function getCnpjFormatAttribute()
    {
        return $this->cnpj ? substr($this->cnpj, 0, 2) . '.' . substr($this->cnpj, 2, 3) . '.' . substr($this->cnpj, 5, 3) . '/' . substr($this->cnpj, 8, 4) . '-' . substr($this->cnpj, 12) : '';
    }
}