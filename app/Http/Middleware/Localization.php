<?php

namespace App\Http\Middleware;

use App\Enums\LanguageType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $acceptedLanguages = LanguageType::getKeyList();
        $headerLanguage = $request->header('lang');

        // Clean the header language (remove extra spaces and commas)
        if ($headerLanguage) {
            $headerLanguage = trim(preg_replace('/\s+/', '', $headerLanguage)); // Remove spaces
            $headerLanguages = explode(',', $headerLanguage); // Split by comma
            $headerLanguage = $headerLanguages[0]; // Take the first language
        }

        // Determine the language to set
        if (Auth::check()) {
            $userLanguage = Auth::user()->lang;
            $languageToSet = in_array($userLanguage, $acceptedLanguages) ? $userLanguage : $acceptedLanguages[0];
        } else {
            $languageToSet = $acceptedLanguages[0];
        }

        // Override with header language if it's valid
        if (isset($headerLanguage) && in_array($headerLanguage, $acceptedLanguages)) {
            $languageToSet = $headerLanguage;
        }

        // Set locale for app and Carbon
        App::setLocale($languageToSet);
        Carbon::setLocale($languageToSet);

        // Set CORS headers
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Allow all domains
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH'); // Allow common methods
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-Token, Accept, Origin'); // Allow common headers
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); // Allow cookies/credentials

        return $response;
    }
}
