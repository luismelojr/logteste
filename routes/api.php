<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create', function (Request $request) {
    $idEncrypted = encrypt(1);
    $provider = new Keycloak([
        'realm' => 'icarros',
        'realm-public-key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlInfDkH67WIGvV6RVTjaRTx3JEgSegHN9dP5B474bRvV/o57FPo1j5q70MzWntIc1EItWPiL6Y3+h7FzjT+aelN7Wp4fRLCNUjZv3CW0ERKB/OimunZuP6b3QBNWdaHQQeZkVT8Su+zQJ8we81sRwd8WhOrb9KpnH56uPPXOew/YaJa+M7pWolerZ4lVvPi83gIfm20RXu88QLN+ga2L8pIdH07miL/CfsAaVTnfIs17F6pbJvwcGeD8qY0fYvKaAhLP7nOAwllHQxWxndzEVpKw5//z+VzM/NDv+QUnOSy/JKOpctZVtdE9Rn3LSIUKWYjFqmGPRMMGpBLN8IbjIwIDAQAB',
        'ssl-required' => 'external',
        'redirectUri' => "https://logteste-production.up.railway.app/api/teste/$idEncrypted",
        'auth-server-url' => 'https://accounts.icarros.com/auth',
        "resource" => "icarros-manheim",
        "clientId" => "icarros-manheim",
        'clientSecret' => '4f88675c-3915-45ce-9a54-7cedf02cb260',
        // "public-client"=> true,
        "credentials" => [
            "secret" => "4f88675c-3915-45ce-9a54-7cedf02cb260"
        ]
    ]);

    $urlAuthorize = 'https://accounts.icarros.com/auth' . $provider->getAuthorizationUrl();
    $urlAuthorize = preg_replace('/&scope[^&]*/', '', $urlAuthorize);
    dd($urlAuthorize);
});

Route::post('teste/{teste}', function (Request $request, $teste) {
    \Illuminate\Support\Facades\Log::alert($request->all());
    \Illuminate\Support\Facades\Log::alert($teste);
    return response()->json([
        'message' => 'ok'
    ]);
});
