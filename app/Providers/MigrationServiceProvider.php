<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

/**
 * @method boolean(string $column)
 * @method timestamps()
 * @method softDeletes()
 * @method string(string $column, int $length)
 */
class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('timestampsField', function () {
            $this->boolean('is_active')->default(true);
            $this->timestamps();
            $this->softDeletes();
            $this->string('created_by', 64)->nullable();
            $this->string('updated_by', 64)->nullable();
            $this->string('deleted_by', 64)->nullable();
        });
    }
}
