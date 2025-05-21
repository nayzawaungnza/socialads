<?php

namespace App\Providers;

use App\Models\Page;
//use App\Models\Admin;
use App\Models\Post;
use App\Models\PostCategory;
// use App\Models\Lesson;
// use App\Models\Student;
// use App\Models\Subject;
// use App\Models\Teacher;
// use App\Models\Assignment;
// use App\Models\Enrollment;
// use App\Models\Transaction;
use App\Models\User;
use App\Models\Image;
use App\Models\Client;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Backend\PostRepository;
use App\Repositories\Backend\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind UserService
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        // Bind PostService
        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(PostRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'Image' => Image::class,
            'Post' => Post::class,
            'Page' => Page::class,
            'Service' => Service::class,
            'User' => User::class,
            'Project' => Project::class,
            'Partner' => Partner::class,
            'Slider' => Slider::class,
            'Client' => Client::class,
            'PostCategory' => PostCategory::class,
            //'Assignment' => Assignment::class,
            //'Transaction' => Transaction::class,
            //'Enrollment' => Enrollment::class,
            
        ]);

        Paginator::useBootstrap();

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
    
            return new LengthAwarePaginator($this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);
        });
        
        
    
    }
}