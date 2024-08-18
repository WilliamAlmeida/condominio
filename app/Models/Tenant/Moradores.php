<?php

namespace App\Models\Tenant;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Moradores extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'moradores';

    use BelongsToTenant;
    use HasTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'nome', 'sobrenome', 'rg', 'cpf', 'telefone', 'whatsapp', 'email', 'foto_id', 'nascimento'
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

    public function imoveis()
    {
        return $this->hasMany('App\Models\Tenant\Imoveis','proprietario_id','id');
    }

    public function pets()
    {
        return $this->hasMany('App\Models\Tenant\Pets','proprietario_id','id');
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