<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Producer;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
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


                // admin
        // task
        $task_reviews_count =  Review::inactive()->count();
        $task_orders_count = Order::notDone()->count();
        $task_contacts_count = Contact::unRead()->count();
        //
        $task_reviews = Review::inactive()->orderByDesc('created_at')->limit(4)->get();
        $task_contacts = Contact::unRead()->orderByDesc('created_at')->limit(4)->get();
        $task_orders = Order::notDone()->orderByDesc('created_at')->limit(4)->get();
        // address
        $addresses = Address::get();
        $wards = Ward::get();
        $districts = District::get();
        $provinces = Province::get();
        $users = User::get();
        view()->share('task_reviews_count',$task_reviews_count);
        view()->share('task_orders_count',$task_orders_count);
        view()->share('task_contacts_count',$task_contacts_count);
        view()->share('task_reviews',$task_reviews);
        view()->share('task_contacts',$task_contacts);
        view()->share('task_orders',$task_orders);
        view()->share('addresses', $addresses);
        view()->share('wards' , $wards);
        view()->share('districts' , $districts);
        view()->share('provinces' , $provinces);
        view()->share('users' , $users);
    }
}
