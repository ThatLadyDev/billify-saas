<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class GetTenant
{
    public function execute(string $tenant)
    {
        $response = Http::get(config('saas.autho') . "/api/tenants/{$tenant}");

        if ($response->successful()) {
            return $response->json('tenant');
        }

        return null; 
    }
}