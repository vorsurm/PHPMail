<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\ThemeViewFinder;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['view']->composer(['layouts.auth', 'layouts.backend', 'layouts.frontend'], Composers\AddStatusMessage::class);
        $this->app['view']->composer('layouts.frontend', Composers\InjectPages::class);

        $this->app['view']->setFinder($this->app['theme.finder']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('theme.finder', function($app)
        {
            $finder = new ThemeViewFinder($app['files'], $app['config']['view.paths']);

            $config = $app['config']['cms.theme'];

            $original_finder = $this->app['view']->getFinder();

            //We need to get our hints from the base level
            $finder->setHints($original_finder->getHints());

            $finder->setBasePath($app['path.public'].'/'.$config['folder']);

            $finder->setActiveTheme($config['active']);

            return $finder;
        });
    }
}
