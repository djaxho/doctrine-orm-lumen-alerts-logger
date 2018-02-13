<?php

namespace Emporium\Svc\Alert;

use Laravel,
    Illuminate\Support\ServiceProvider,
    Illuminate,
    LaravelDoctrine,
    Monolog;

class AlertServiceProvider extends ServiceProvider
{
    public function register() {
        $this->mergeConfigFrom($this->app->basePath('config/migrations.php'), 'migrations');
        $this->app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Laravel\Lumen\Exceptions\Handler::class);
        $this->app->singleton(Illuminate\Contracts\Console\Kernel::class, Laravel\Lumen\Console\Kernel::class);
        $this->app['log']->pushProcessor(new Monolog\Processor\PsrLogMessageProcessor());
        $this->app->register(LaravelDoctrine\ORM\DoctrineServiceProvider::class);
        $this->app->register(LaravelDoctrine\Migrations\MigrationsServiceProvider::class);
        $this->app->register(Illuminate\Redis\RedisServiceProvider::class);
        $this->app->register(Model\ModelServiceProvider::class);
    }
}
