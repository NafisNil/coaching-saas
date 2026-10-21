<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                    'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => trim($request->user()->first_name . ' ' . $request->user()->last_name),
                    'email' => $request->user()->email,
                    'type' => $request->user()->user_type,
                    'institution' => $request->user()->institution ? [
                        'id' => $request->user()->institution->id,
                        'name' => $request->user()->institution->name,
                        'currency' => $request->user()->institution->default_currency,
                    ] : null,
                ] : null,
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
