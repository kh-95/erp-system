<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro("customDateFromTo",  function ($request, $columnName = 'created_at', $dateFrom = 'created_from', $dateTo = 'created_to') {
            if (isset($request->{$dateFrom})) {
                $created_from = date('Y-m-d', strtotime($request->{$dateFrom}));

                $this->whereDate($columnName, ">=", $created_from);
            }

            if (isset($request->{$dateTo})) {
                $created_to = date('Y-m-d', strtotime($request->{$dateTo}));

                $this->whereDate($columnName, "<=", $created_to);
            }

            return $this;
        });
    }
}
