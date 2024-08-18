<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class DeleteValuesTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TenantWithDatabase|Model */
    protected $tenant;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        // Terminate execution of this job & other jobs in the pipeline
        if ($this->tenant->getInternal('create_database') === false) {
            return false;
        }

        info("Delete Values Tenant {$this->tenant->nome_fantasia} init.");

        DB::beginTransaction();

        try {
            $this->tenant->users()->sync([]);
            // $this->tenant->horarios()->delete();

            DB::table(config('permission.table_names.model_has_roles'))->where('tenant_id', $this->tenant->id)->delete();

            info("Delete Values Tenant {$this->tenant->nome_fantasia} finish.");

            DB::commit();

        } catch (\Throwable $th) {
            throw $th;

            DB::rollback();
        }
    }

    public function failed(Throwable $exception): void
    {
        info("Delete Values Tenant {$this->tenant->nome_fantasia} error.");
        info($exception);
    }
}