<?php

namespace App\Providers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\ResourceInterface;
use App\Http\Resources\ShowUserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    private $resourceName;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();

//        App::bind('ServerRequestInterface ', 'LoginRequest ');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success_message', function($message, $data = null) {
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $data,
            ]);
        });

        //TODO: success_data Macro Is Different And Need To Config More
        Response::macro('success_data', function($message, $data ,ResourceInterface $resourceName , $method = 'index') {
            if($method == 'index'){
                $data = $resourceName->collection();

            }elseif ($method == 'show'){
                $data = new (get_class($resourceName));
            }
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $data,
            ]);
        });

        Response::macro('error', function($message,  $code = 500, $data = null) {
            return response()->json([
                'status' => 0,
                'error' => $message,
                'data' => $data,
            ], $code);
        });
    }
}
