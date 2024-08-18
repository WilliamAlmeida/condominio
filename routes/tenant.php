<?php

declare(strict_types=1);

use App\Livewire\Conta\ContaEdit;
use App\Livewire\Conta\ContaView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Tenant\Pets\PetIndex;
use App\Livewire\Tenant\Blocos\BlocoIndex;
use App\Livewire\Tenant\Imoveis\ImovelIndex;
use App\Livewire\Tenant\Usuarios\UsuarioIndex;
use App\Livewire\Tenant\Veiculos\VeiculoIndex;
use App\Livewire\Tenant\Moradores\MoradorIndex;
use App\Http\Middleware\InitializeTenancyByPath;
use App\Livewire\Tenant\Dashboard\DashboardIndex;
use App\Livewire\Tenant\Condominio\CondominioEdit;
use App\Livewire\Tenant\EmpresasServicos\EmpresaServicoIndex;
use App\Livewire\Tenant\PrestadoresServicos\PrestadorServicoIndex;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

// Route::middleware([
//     'web',
//     InitializeTenancyByDomain::class,
//     PreventAccessFromCentralDomains::class,
// ])->group(function () {
//     Route::get('/', function () {
//         return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//     });
// });

Route::middleware([
    'web', 'auth',
    InitializeTenancyByPath::class,
])->prefix('condominio/{tenant}')->name('tenant.')->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    Route::get('/perfil', ContaView::class)->name('conta.view');
    Route::get('/configuracao/minha-conta', ContaEdit::class)->name('conta.edit');
    
    Route::get('/usuarios', UsuarioIndex::class)->name('usuarios.index');
    
    Route::get('/condominio', CondominioEdit::class)->name('condominio.edit');

    Route::prefix('cadastros')->group(function () {
        Route::get('/blocos', BlocoIndex::class)->name('blocos.index');
        Route::get('/moradores', MoradorIndex::class)->name('moradores.index');
        Route::get('/imoveis', ImovelIndex::class)->name('imoveis.index');
        Route::get('/pets', PetIndex::class)->name('pets.index');
        Route::get('/veiculos', VeiculoIndex::class)->name('veiculos.index');
        Route::get('/prestadores-servicos', PrestadorServicoIndex::class)->name('prestadores-servicos.index');
        Route::get('/empresas-servicos', EmpresaServicoIndex::class)->name('empresas-servicos.index');
    });
});