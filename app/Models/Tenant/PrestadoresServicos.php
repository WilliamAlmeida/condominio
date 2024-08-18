<?php

namespace App\Models\Tenant;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PrestadoresServicos extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'prestadores_servicos';

    use BelongsToTenant;
    use HasTenant;

    public static $tipos_prestadores = [
        [
            'name' => 'Pessoa Física', 'id' => 'pessoa_fisica'
        ],
        [
            'name' => 'Pessoa Jurídica', 'id' => 'pessoa_juridica'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'tipo', 'categoria', 'nome', 'sobrenome', 'cpf', 'rg', 'telefone', 'whatsapp', 'email', 'site', 'endereco_id', 'foto_id', 'descricao', 'empresa_id', 'nascimento'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            if ($model->foto) $model->fotoDelete();
        });
    }

    public function condominios()
    {
        return $this->hasOne('App\Models\Tenant','id','tenant_id');
    }

    public function foto()
    {
        return $this->hasOne('App\Models\Files', 'id', 'foto_id');
    }

    public function fotoDelete(): bool
    {
        if ($this->foto) {
            Storage::disk('public')->delete($this->foto->url);
            return $this->foto->delete();
        }

        return true;
    }

    public function endereco()
    {
        return $this->hasOne('App\Models\Tenant\Enderecos','id','endereco_id');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Tenant\EmpresasServicos','id','empresa_id');
    }

    public function getTipoPrestador(): array
    {
        $index = collect(self::$tipos_prestadores)->firstWhere('id', $this->tipo);
        return ($index) ? $index : [];
    }

    public function getNomeCompletoAttribute()
    {
        return $this->nome . ' ' . $this->sobrenome;
    }

    public function getTelefoneFormatAttribute()
    {
        return $this->telefone ? '(' . substr($this->telefone, 0, 2) . ') ' . substr($this->telefone, 2, 5) . '-' . substr($this->telefone, 7) : '';
    }

    public function getWhatsappFormatAttribute()
    {
        return $this->whatsapp ? '(' . substr($this->whatsapp, 0, 2) . ') ' . substr($this->whatsapp, 2, 5) . '-' . substr($this->whatsapp, 7) : '';
    }

    public function getCpfFormatAttribute()
    {
        return $this->cpf ? substr($this->cpf, 0, 3) . '.' . substr($this->cpf, 3, 3) . '.' . substr($this->cpf, 6, 3) . '-' . substr($this->cpf, 9) : '';
    }
}