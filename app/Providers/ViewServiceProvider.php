<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        if (! request()->is('admin/*')) {
            Paginator::defaultView('vendor.pagination.boighor');

            view()->composer('*', function ($view) {

                if (! Cache::has('recent_posts')) {
                    $recent_posts = Post::with(['category', 'media', 'user'])
                    ->whereHas('category', function ($query) {
                        $query->whereStatus(1);
                    })
                    ->whereHas('user', function ($query) {
                        $query->whereStatus(1);
                    })
                    ->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();
                    
                    Cache::remember('recent_posts', 3600, function () use ($recent_posts) {
                        return $recent_posts;
                    });
                }
                $recent_posts = Cache::get('recent_posts');


                if (! Cache::has('recent_commints')) {
                    $recent_commints = Comment::whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();
                    
                    Cache::remember('recent_commints', 3600, function () use ($recent_commints) {
                        return $recent_commints;
                    });
                }
                $recent_commints = Cache::get('recent_commints');


                if (! Cache::has('global_categories')) {
                    $global_categories = Category::whereStatus(1)->orderBy('id', 'desc')->get();
                    
                    Cache::remember('global_categories', 3600, function () use ($global_categories) {
                        return $global_categories;
                    });
                }
                $global_categories = Cache::get('global_categories');


                if (! Cache::has('global_archives')) {
                    $global_archives = Post::whereStatus(1)->orderBy('created_at', 'desc')
                        ->select(DB::raw("Year(created_at) as year"), DB::raw("Month(created_at) as month"))
                        ->pluck('year', 'month')->toArray();
                    
                    Cache::remember('global_archives', 3600, function () use ($global_archives) {
                        return $global_archives;
                    });
                }
                $global_archives = Cache::get('global_archives');

                $view->with([
                    'recent_posts'      => $recent_posts,
                    'recent_commints'   => $recent_commints,
                    'global_categories' => $global_categories,
                    'global_archives'   => $global_archives,
                ]);

            });
        }
    }
}