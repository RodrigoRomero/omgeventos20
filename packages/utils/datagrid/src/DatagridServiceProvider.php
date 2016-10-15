<?php namespace OMG\Datagrid;

use Illuminate\Support\ServiceProvider;

class DatagridServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'datagrid');
        //require __DIR__ . '/../vendor/autoload.php';

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('datagrid', function () {
            return new \OMG\Datagrid\Datagrid;
        });
    }
}
