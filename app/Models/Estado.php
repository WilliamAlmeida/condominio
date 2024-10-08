<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
	protected $table = 'estados';
	protected $primaryKey = 'id';
	public $timestamps = false;

	/*Add your validation rules here*/
	public static $rules = array(
		'nome' => array('unique:cidade','required','min:1','alpha'),
		'codigo' => array('required','min:1','numeric'),
		'uf' => array('required','min:2','max:2','alpha'),
		'pais_id' => array('required','min:1','numeric'),
	);

	public static $rules_u = array(
		'nome' => array('required','min:1','alpha'),
		'codigo' => array('required','min:1','numeric'),
		'uf' => array('required','min:2','max:2','alpha'),
		'pais_id' => array('required','min:1','numeric'),
	);

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nome', 'codigo', 'uf', 'pais_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
    ];

    protected $attributes = [
    	'pais_id' => 1
    ];

    public function pais()
    {
    	return $this->hasOne('App\Models\Pais', 'id', 'pais_id');
    }

    public function cidades()
    {
      return $this->hasMany('App\Models\Cidade', 'estado_id', 'id');
    }

    public function condominios()
    {
      return $this->hasMany('App\Models\Tenant', 'estado_id', 'id');
    }

    public function user()
    {
    	return $this->hasMany('App\User', 'end_estado_id', 'id');
    }

    public function fornecedores()
    {
    	return $this->belongsTo('App\Models\Tenant\Fornecedores', 'id', 'estado_id');
    }
}