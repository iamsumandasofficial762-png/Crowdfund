<?php

namespace App\Http\Middleware;

use App\Models\Fundraiser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApprovedFundraiser
{
    public function handle(Request $request, Closure $next): Response
    {
        $fundraiser = Fundraiser::approved()->find($request->session()->get('fundraiser_id'));

        if (! $fundraiser) {
            $request->session()->forget('fundraiser_id');

            return redirect()->route('fundraiser.login')->withErrors([
                'email' => 'Please login with an approved fundraiser account.',
            ]);
        }

        $request->attributes->set('fundraiser', $fundraiser);
        view()->share('currentFundraiser', $fundraiser);

        return $next($request);
    }
}
