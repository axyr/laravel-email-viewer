<?php

namespace Axyr\EmailViewer;

use Axyr\EmailViewer\Contracts\EmailParser;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EmailViewerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        $this->bootMigrations();
        $this->bootViews();
        $this->bootCommands();
        $this->bootImplementations();
        $this->bootRoutes();
        $this->bootEventListeners();
    }

    protected function registerConfig(): void
    {
        $file = __DIR__ . '/../config/emailviewer.php';

        $this->mergeConfigFrom($file, 'emailviewer');
        $this->publishes([$file => config_path('emailviewer.php')]);
    }

    protected function bootMigrations(): void
    {
        $file = __DIR__ . '/../database/migrations';

        $this->loadMigrationsFrom($file);
        $this->publishesMigrations([$file => database_path('migrations')]);
    }

    protected function bootViews(): void
    {
        $file = __DIR__ . '/../resources/views';

        $this->loadViewsFrom($file, 'email-viewer');
        $this->publishes([$file => resource_path('views/vendor/email-viewer')]);
    }

    protected function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\EmailViewerList::class,
                Commands\EmailViewerShow::class,
                Commands\EmailViewerDelete::class,
            ]);
        }
    }

    protected function bootEventListeners(): void
    {
        Event::listen(
            MessageSending::class,
            $this->app['config']['emailviewer.listener'],
        );
    }

    protected function bootImplementations(): void
    {
        $this->app->bind(EmailParser::class, fn($app) => $app->make($app->config['emailviewer.parser']));
    }

    protected function bootRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/emailviewer.php');
    }
}
