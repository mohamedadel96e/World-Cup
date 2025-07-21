<?php

namespace App\Providers;

use App\Services\CurrencyConversionService;
use App\Services\QRCodeService;
use Cloudinary\Cloudinary;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Bombing;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Cloudinary::class, function () {
            return new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);
        });

        $this->app->singleton(CurrencyConversionService::class, function ($app) {
            return new CurrencyConversionService();
        });

        $this->app->singleton(QRCodeService::class, function ($app) {
            return new QRCodeService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            $unseenBombings = [];

            if ($user && $user->country_id) {
                $unseenBombings = Bombing::where('target_country_id', $user->country_id)
                    ->whereDoesntHave('views', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->latest()
                    ->get();
            }

            $view->with('unseenBombings', $unseenBombings);
        });

    }
}
