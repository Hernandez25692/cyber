<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/redirect', function () {
                $user = Auth::user();

                if (!$user) {
                    return redirect('/login');
                }

                return match ($user->rol) {
                    'admin' => redirect()->route('admin.index'),
                    default => redirect()->route('pos'),
                };
            })->name('redirect');
        });
    }
}
