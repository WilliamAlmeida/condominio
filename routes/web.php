<?php

use App\Livewire\Conta\ContaEdit;
use App\Livewire\Conta\ContaView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Roles\RoleIndex;
use App\Http\Controllers\ManifestController;
use App\Livewire\Admin\Usuarios\UsuarioIndex;
use App\Http\Controllers\InvitationController;
use App\Livewire\Admin\Dashboard\DashboardIndex;
use App\Livewire\Admin\Condominios\CondominioIndex;
use App\Livewire\Admin\Permissions\PermissionIndex;
use App\Livewire\Admin\Condominios\CondominioCreate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/accept-invitation-tenant', [InvitationController::class, 'acceptInvitationTenantUser'])->name('aceitando.convite.condominio');
Route::get('/manifest.json', [ManifestController::class, 'manifest'])->name('manifest.json');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    Route::get('/perfil', ContaView::class)->name('conta.view');
    Route::get('/configuracao/minha-conta', ContaEdit::class)->name('conta.edit');

    Route::get('/condominios', CondominioIndex::class)->name('condominios.index');
    Route::get('/condominio/create', CondominioCreate::class)->name('condominio.create');

    Route::get('/funcoes', RoleIndex::class)->name('funcoes.index');
    Route::get('/funcoes/permissoes', PermissionIndex::class)->name('permissoes.index');
    
    Route::get('/usuarios', UsuarioIndex::class)->name('usuarios.index');

    Route::get('/manifest/generate', [ManifestController::class, 'generate'])->name('manifest.generate');
});

require __DIR__.'/auth.php';
