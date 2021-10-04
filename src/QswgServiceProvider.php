<?php

namespace WillyGilly\Qswg;

use WillyGilly\Qswg\Console\ControllerMakerCommand;
use WillyGilly\Qswg\Console\MakeLangCommand;
use WillyGilly\Qswg\Console\QSWGInstallCommand;
use WillyGilly\Qswg\Console\ViewMakerCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class QswgServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->loadRoutes();
        $this->loadConfig();
    }

    private function registerCommands()
    {
        $this->commands([
            ControllerMakerCommand::class,
            QSWGInstallCommand::class,
            ViewMakerCommand::class,
            MakeLangCommand::class,
        ]);
    }

    /**
     * Get the absolute path to some package resource.
     *
     * @param string $path The relative path to the resource
     * @return string
     */
    private function packagePath(string $path): string
    {
        return __DIR__."/../$path";
    }

    /**
     * Load the package config.
     *
     * @return void
     */
    private function loadConfig()
    {
        $configPath = $this->packagePath('config/qswg.php');
        $this->mergeConfigFrom($configPath, 'qswg');
    }

    /**
     * Load the package web routes.
     *
     * @return void
     */
    private function loadRoutes()
    {
        $routesCfg = [
            'middleware' => ['web'],
        ];

        Route::group($routesCfg, function () {
            $routesPath = $this->packagePath('routes/web.php');
            $this->loadRoutesFrom($routesPath);
        });
    }

}
