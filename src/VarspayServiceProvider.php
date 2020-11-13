<?php


/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Mujtech Mujeeb <mujeeb.muhideen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mujhtech\Varspay;

use Illuminate\Support\ServiceProvider;
use Mujhtech\Varspay\Console\VarspayInstallCommand;


class VarspayServiceProvider extends ServiceProvider
{

     /*
    * Indicates if loading of the provider is deferred.
    *
    * @var bool
    */


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('laravel-varspay', function ($app) {

            return new Varspay;

        });
    }

    /**
    * Publishes all the config file this package needs to function
    */

    public function boot()
    {
        $config = realpath(__DIR__.'/../config/varspay-tech.php');

        $this->publishes([
            $config => config_path('varspay-tech.php')
        ]);
        $this->registerCommands();
    }


    /**
    * Get the services provided by the provider
    * @return array
    */

    public function provides()
    {
        return ['laravel-varspay'];
    }


    private function registerCommands()
    {
        $this->commands([
            VarspayInstallCommand::class,
        ]);
    }

}