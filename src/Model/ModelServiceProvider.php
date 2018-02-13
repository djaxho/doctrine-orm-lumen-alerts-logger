<?php

namespace Emporium\Svc\Alert\Model;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton(Alert\StoreAlert::class);
        $this->app->singleton(Report\ValidateReport::class, function() {
		  return new Report\ValidateReport(Alert\AlertSearch::createEngine());
		});
        $this->app->singleton(Alert\AlertSearch::class, function($app) {
            return new Alert\AlertSearch($app->make('em'));
        });

    }
}
