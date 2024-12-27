<?php

namespace App\Providers;

use App\Interfaces\IAuthorRepository;
use App\Interfaces\INewsRepository;
use App\Interfaces\ISourceRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\NewsRepository;
use App\Repositories\SourceRepository;
use App\repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(INewsRepository::class, NewsRepository::class);
        $this->app->bind(IAuthorRepository::class, AuthorRepository::class);
        $this->app->bind(ISourceRepository::class, SourceRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
