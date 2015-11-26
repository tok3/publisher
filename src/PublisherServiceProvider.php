<?php
namespace Tok3\Publisher;

use Illuminate\Support\ServiceProvider;
use \Tok3\Publisher\Models\Image as Image;
use \Tok3\Publisher\Models\Page as Page;
class PublisherServiceProvider extends ServiceProvider
{
    public function register()
    {
        setlocale(LC_TIME, \Config::get('app.locale') . '_' . strtoupper(\Config::get('app.locale')));

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $this->app->register('Collective\Html\HtmlServiceProvider');

        $this->app->alias('Form', 'Collective\Html\FormFacade');
        $this->app->alias('HTML', 'Collective\Html\HtmlFacade');

        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('HTML', 'Collective\Html\HtmlFacade');

        $this->app->bind('tok3-publisher', function ()
        {
            return new Publisher;
        });
/*
        $this->mergeConfigFrom(
            __DIR__ . '/config/main.php', 'tok3-demo-main'
        );
*/

    }

    public function boot()
    {

        require __DIR__ . '/Http/routes.php';


        $this->loadViewsFrom(__DIR__ . '/views', 'tok3-publisher');

        $this->publishes([
            __DIR__ . '/config/publisher.php' => config_path('tok3-publisher.php')
        ], 'package.php');


                $this->publishes([
                    __DIR__ . '/views' => base_path('resources/views/vendor/tok3-publisher')
                ], 'views');


                $this->publishes([
                    __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
                ], 'migrations');

        $this->publishes([
            __DIR__ . '/seeds' => base_path('database/seeds')
        ], 'views');



        Page::deleting(function ($page) {

            if(count($page->images) > 0)
            {
                foreach ($page->images as $image)
                {
                    unlink(\Config::get('tok3-publisher.images_dir', 'images/tok3-publisher/') . $image->name);
                }


            }
        });

    }
}