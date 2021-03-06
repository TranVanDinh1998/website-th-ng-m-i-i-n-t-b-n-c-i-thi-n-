<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Producer;
use App\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    // public function __construct(Category $category, Producer $producer)
    // {
    //     $this->category = $category;
    //     $this->producer = $producer;
    // }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $categories = Category::active()->get();
        view()->share('categories', $categories);

        $collections = Collection::active()->get();
        view()->share('collections', $collections);

        $producers = Producer::active()->get();
        view()->share('producers', $producers);

        $tags = Tag::orderByDesc('view')->limit(10)->get();
        view()->share('tags', $tags);
        Paginator::useBootstrap();

    }
}
