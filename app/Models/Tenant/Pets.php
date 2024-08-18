<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Pets extends Model
{
	protected $primaryKey = 'id';

    use BelongsToTenant;

    public static $portes_pets = [
        [
            'name' => 'Pequeno', 'id' => 'pequeno'
        ],
        [
            'name' => 'Médio', 'id' => 'medio'
        ],
        [
            'name' => 'Grande', 'id' => 'grande'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'proprietario_id', 'nome', 'raca', 'cor', 'porte', 'foto_id', 'nascimento'
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

    public function proprietario()
    {
        return $this->hasOne('App\Models\Tenant\Moradores','id','proprietario_id');
    }
    
    public function getPortePet(): array
    {
        $index = collect(self::$portes_pets)->firstWhere('id', $this->porte);
        return ($index) ? $index : [];
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
}