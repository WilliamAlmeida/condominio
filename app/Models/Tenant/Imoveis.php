<?php

namespace App\Models\Tenant;

use App\Models\Files;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Imoveis extends Model
{
	protected $primaryKey = 'id';

    use BelongsToTenant;

    public static $tipos_imoveis = [
        [
            'name' => 'Casa', 'id' => 'casa'
        ],
        [
            'name' => 'Apartamento', 'id' => 'apartamento'
        ]
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenant_id', 'bloco_id', 'tipo', 'andar', 'rua', 'numero', 'proprietario_id'
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
            if (count($model->fotos)) {
                $model->fotos->each(function($foto) use ($model) {
                    $model->fotoDelete($foto);
                });
            }
        });
    }

    public function fotoDelete(null|Files $foto): bool
    {
        if ($foto && $foto->rel_id == $this->id && $foto->rel_table == $this->getTable()) {
            Storage::disk('public')->delete($foto->url);
            return $foto->delete();
        }else{
            $this->fotos->each(function($foto) {
                $foto->fotoDelete($foto);
            });
        }

        return true;
    }

    public function condominios()
    {
        return $this->hasOne('App\Models\Tenant','id','tenant_id');
    }

    public function blocos()
    {
        return $this->hasOne('App\Models\Tenant\Blocos','id','bloco_id');
    }

    public function proprietario()
    {
        return $this->hasOne('App\Models\Tenant\Moradores','id','proprietario_id');
    }

    public function moradores()
    {
        return $this->belongsToMany('App\Models\Tenant\Moradores','imoveis_has_moradores','imovel_id','morador_id');
    }
    
    public function getTipoImovel(): array
    {
        $index = collect(self::$tipos_imoveis)->firstWhere('id', $this->tipo);
        return ($index) ? $index : [];
    }

    public function fotos()
    {
        return $this->hasMany('App\Models\Files','rel_id', 'id')->where('rel_table', 'imoveis');
    }
}