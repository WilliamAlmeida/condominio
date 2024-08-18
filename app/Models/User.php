<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Traits\BelongsToManyTenant;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    use BelongsToManyTenant, HasRoles;

    /**
    * The model class used for the tenant relationship in the many-to-many association.
    * This can be set using either ::class or the class path as a string.
    *
    * @var string
    */
    // protected $tenant_relation_model = UserTenants::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'foto_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const USER = 0;
    const CONDOMINIO = 1;
    const ADMIN = 2;

    static public $list_type_user = [
        ['type' => self::USER, 'label' => 'Usuário'],
        ['type' => self::CONDOMINIO, 'label' => 'Condominio'],
        ['type' => self::ADMIN, 'label' => 'Admin'],
    ];

    public function scopeTenant($query): void
    {
        $query->whereHas('tenants', function ($query) {
            $query->where('tenant_id', tenant('id'));
        });
    }

    public function getTypeUser(): string
    {
        return match ($this->type) {
            self::USER  => "Usuário",
            self::CONDOMINIO => "Condominio",
            self::ADMIN => "Admin"
        };
    }

    public function isAdmin(): bool
    {
        return $this->type == self::ADMIN;
    }

    public function isCondominio(): bool
    {
        return $this->type == self::CONDOMINIO;
    }

    public function isUser(): bool
    {
        return $this->type == self::USER;
    }

    public function condominio()
    {
        return $this->tenants();
    }

    public function caixas()
    {
        return $this->hasMany('App\Models\Tenant\Caixa', 'user_id', 'id');
    }

    public function caixa()
    {
        return $this->hasOne('App\Models\Tenant\Caixa', 'user_id', 'id')->whereIn('status', [0])->latest();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            if ($model->foto) $model->fotoDelete();
        });
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
