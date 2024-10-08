<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasScopedValidationRules;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasScopedValidationRules, HasFactory;

    // protected $table = 'condominios';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    /*Add your validation rules here*/
    public static $rules = array(
        'id_tipo_condominio' => array('min:0'),
        'nome_fantasia' => array('required','min:0','max:255'),
        'slug' => array('min:0','max:255'),
        'razao_social' => array('min:0','max:255'),
        'idpais' => array('min:0','max:255'),
        'estado_id' => array('max:255'),
        'cidade_id' => array('max:255'),
        'cnpj' => array('min:0','max:18'),
        'inscricao_estadual' => array('min:0','max:20'),
        'cpf' => array('min:0','max:14'),
        'end_logradouro' => array('min:0','max:255'),
        'end_numero' => array('min:0','max:10'),
        'end_complemento' => array('min:0','max:255'),
        'end_bairro' => array('min:0','max:255'),
        'end_cidade' => array('min:0','max:255'),
        'end_cep' => array('min:0','max:14'),
        'file_ticket' => array('min:0'),
        'file_logo' => array('min:0'),
        'file_background' => array('min:0'),
        'whatsapp' => array('min:0'),
        'whatsapp_status' => array('min:0'),
        'tema' => array('min:0'),
        'keywords' => array('min:0'),
        'description' => array('min:0','max:160'),
        'status' => array('min:0','max:1','numeric'),
        'status_manual' => array('min:0','max:1','numeric'),
        'status_mesa' => array('min:0','max:1','numeric'),
        'impressao' => array('min:0','max:1','numeric'),
        'impressao_mesa' => array('min:0','max:1','numeric'),
        'taxa_entrega' => array('min:0'),
        'valor_min_entrega' => array('min:0'),
        'isento_taxa_entrega' => array('min:0'),
        'negar_entrega' => array('min:0'),
        'tempo_entrega_min' => array('min:0'),
        'tempo_entrega_max' => array('min:0'),
        'ultimo_pedido' => array('min:0'),
        'couvert' => array('min:0'),
        'garcom' => array('min:0'),
        'rate' => array('min:0'),
        'manifest_v' => array('min:0','max:15'),
        's_mesa' => array('min:0'),
    );

    public static $rules_u = array(
        'id_tipo_condominio' => array('min:0'),
        'nome_fantasia' => array('required','min:0','max:255'),
        'slug' => array('min:0','max:255'),
        'razao_social' => array('min:0','max:255'),
        'idpais' => array('min:0','max:255'),
        'estado_id' => array('max:255'),
        'cidade_id' => array('max:255'),
        'cnpj' => array('min:0','max:18'),
        'inscricao_estadual' => array('min:0','max:20'),
        'cpf' => array('min:0','max:14'),
        'end_logradouro' => array('min:0','max:255'),
        'end_numero' => array('min:0','max:10'),
        'end_complemento' => array('min:0','max:255'),
        'end_bairro' => array('min:0','max:255'),
        'end_cidade' => array('min:0','max:255'),
        'end_cep' => array('min:0','max:14'),
        'file_ticket' => array('min:0'),
        'file_logo' => array('min:0'),
        'file_background' => array('min:0'),
        'whatsapp' => array('min:0'),
        'whatsapp_status' => array('min:0'),
        'tema' => array('min:0'),
        'keywords' => array('min:0'),
        'description' => array('min:0','max:160'),
        'status' => array('min:0','max:1','numeric'),
        'status_manual' => array('min:0','max:1','numeric'),
        'status_mesa' => array('min:0','max:1','numeric'),
        'impressao' => array('min:0','max:1','numeric'),
        'impressao_mesa' => array('min:0','max:1','numeric'),
        'taxa_entrega' => array('min:0'),
        'valor_min_entrega' => array('min:0'),
        'isento_taxa_entrega' => array('min:0'),
        'negar_entrega' => array('min:0'),
        'tempo_entrega_min' => array('min:0'),
        'tempo_entrega_max' => array('min:0'),
        'ultimo_pedido' => array('min:0'),
        'couvert' => array('min:0'),
        'garcom' => array('min:0'),
        'rate' => array('min:0'),
        'manifest_v' => array('min:0','max:15'),
        's_mesa' => array('min:0'),
    );

    public static $tipos_condominios = [
        [
            'name' => 'Restaurante', 'id' => 1, 'desc' => 'Restaurantes, Hamburguerias, Sorveterias, Marmitarias, Lanchonetes, etc.'
        ],
        [
            'name' => 'Mercado', 'id' => 2, 'desc' => 'Supermercados, Hortifrutis, Mercearias, etc.'
        ],
        [
            'name' => 'Bebidas', 'id' => 3, 'desc' => 'Distribuidoras, Adegas, Choperias, Casas de Cervejas, etc.'
        ],
        [
            'name' => 'Farmácia', 'id' => 4, 'desc' => 'Farmácias, Drogarias, Medicamentos Naturais, Perfumaria, etc.'
        ],
        [
            'name' => 'Pet Shop', 'id' => 5, 'desc' => 'Pets Shops, Casas de Ração, Venterinárias, etc.'
        ],
        [
            'name' => 'Vestuário', 'id' => 6, 'desc' => 'Loja de Roupa, Sapatos, etc.'
        ],
        [
            'name' => 'Eletrônicos', 'id' => 7, 'desc' => 'Loja de Celular, TV, Videogames, etc.'
        ],
        [
            'name' => 'Sorveteria', 'id' => 8, 'desc' => 'Açai, Sorvetes, etc.'
        ],
        [
            'name' => 'Outros', 'id' => 999, 'desc' => 'Outros.'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tipo_condominio', 'nome_fantasia', 'slug', 'razao_social', 'idpais', 'estado_id', 'cidade_id', 'cnpj', 'inscricao_estadual', 'cpf', 'end_logradouro', 'end_numero', 'end_complemento', 'end_bairro', 'end_cidade', 'end_cep', 'file_ticket', 'file_logo', 'file_background', 'whatsapp', 'whatsapp_status', 'tema', 'keywords', 'description', 'status', 'status_manual', 'status_mesa', 'impressao', 'impressao_mesa', 'taxa_entrega', 'valor_min_entrega', 'isento_taxa_entrega', 'negar_entrega', 'tempo_entrega_min', 'tempo_entrega_max', 'ultimo_pedido', 'couvert', 'garcom', 'rate', 'manifest_v', 's_mesa'
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id', 'id_tipo_condominio', 'nome_fantasia', 'slug', 'razao_social', 'idpais', 'estado_id', 'cidade_id', 'cnpj', 'inscricao_estadual', 'cpf', 'end_logradouro', 'end_numero', 'end_complemento', 'end_bairro', 'end_cidade', 'end_cep', 'file_ticket', 'file_logo', 'file_background', 'whatsapp', 'whatsapp_status', 'tema', 'keywords', 'description', 'status', 'status_manual', 'status_mesa', 'impressao', 'impressao_mesa', 'taxa_entrega', 'valor_min_entrega', 'isento_taxa_entrega', 'negar_entrega', 'tempo_entrega_min', 'tempo_entrega_max', 'ultimo_pedido', 'couvert', 'garcom', 'rate', 'manifest_v', 's_mesa'
        ];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
    ];

    public function getIncrementing()
    {
        return true;
    }

    // public function users()
    // {
    //     return $this->belongsTo('App\User', 'tenant_id', 'id');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tenant');
    }

    public function logo()
    {
        return $this->hasOne('App\Models\Files', 'id', 'file_logo');
    }

    public function pais()
    {
        return $this->hasOne('App\Models\Pais', 'id', 'pais_id');
    }

    public function estado()
    {
        return $this->hasOne('App\Models\Estado', 'id', 'estado_id');
    }

    public function cidade()
    {
        return $this->hasOne('App\Models\Cidade', 'id', 'cidade_id');
    }

    public function horarios()
    {
        return $this->hasMany('App\Models\Horarios','tenant_id','id');
    }
    
    public function getTipoCondominio(): array
    {
        $index = collect(self::$tipos_condominios)->firstWhere('id', $this->id_tipo_condominio);
        return ($index) ? $index : [];
    }

    public function blocos()
    {
        return $this->hasMany('App\Models\Tenant\Blocos', 'tenant_id', 'id');
    }

    public function moradores()
    {
        return $this->hasMany('App\Models\Tenant\Moradores', 'tenant_id', 'id');
    }

    public function imoveis()
    {
        return $this->hasMany('App\Models\Tenant\Imoveis', 'tenant_id', 'id');
    }

    public function pets()
    {
        return $this->hasMany('App\Models\Tenant\Pets', 'tenant_id', 'id');
    }

    public function veiculos()
    {
        return $this->hasMany('App\Models\Tenant\Veiculos', 'tenant_id', 'id');
    }

    public function prestadoresservicos()
    {
        return $this->hasMany('App\Models\Tenant\PrestadoresServicos', 'tenant_id', 'id');
    }

    public function empresasservicos()
    {
        return $this->hasMany('App\Models\Tenant\EmpresasServicos', 'tenant_id', 'id');
    }

    public function enderecos()
    {
        return $this->hasMany('App\Models\Tenant\Enderecos', 'tenant_id', 'id');
    }

    /*

    public function background()
    {
        return $this->hasOne('App\Models\File', 'id', 'file_background');
    }
    */
}