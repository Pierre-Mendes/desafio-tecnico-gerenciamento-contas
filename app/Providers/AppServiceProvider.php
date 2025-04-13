<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\TransacaoPorTipoPagamentoFactory;
use App\Repositories\Conta\ContaRepositoryDatabase;
use App\Repositories\Conta\ContaRepositoryInterface;
use App\Services\Transacao\ProcessarTransacaoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContaRepositoryInterface::class, ContaRepositoryDatabase::class);

        $this->app->bind(ProcessarTransacaoService::class, function ($app) {
            return new ProcessarTransacaoService(
                $app->make(ContaRepositoryInterface::class),
                $app->make(TransacaoPorTipoPagamentoFactory::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
