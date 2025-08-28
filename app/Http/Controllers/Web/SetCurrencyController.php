<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Financial\MultiCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class SetCurrencyController extends Controller
{
    public function setCurrency(Request $request)
    {
        // Log the incoming request data
        Log::debug('SetCurrencyController - Incoming Request', [
            'currency' => $request->get('currency'),
            'previous_url' => $request->get('previous_url')
        ]);

        // Validate the incoming request
        $this->validate($request, [
            'currency' => 'required'
        ]);
        Log::debug('SetCurrencyController - Validation passed');

        $currency = $request->get('currency');
        Log::debug('SetCurrencyController - Currency Selected', ['currency' => $currency]);

        $multiCurrency = new MultiCurrency();
        Log::debug('SetCurrencyController - MultiCurrency Object Created');

        $currencies = $multiCurrency->getCurrencies();
        Log::debug('SetCurrencyController - Retrieved Currencies', ['currencies' => $currencies]);

        $signs = $currencies->pluck('currency')->toArray();
        Log::debug('SetCurrencyController - Plucked Currencies', ['currency_signs' => $signs]);

        // Check if the currency is valid
        if (in_array($currency, $signs)) {
            Log::debug('SetCurrencyController - Currency is valid');

            // Check if the user is authenticated
            if (auth()->check()) {
                Log::debug('SetCurrencyController - User is authenticated');
                $user = auth()->user();
                Log::debug('SetCurrencyController - Updating User Currency', ['user_id' => $user->id, 'currency' => $currency]);
                $user->update([
                    'currency' => $currency
                ]);

                // Return success response for authenticated user
                return response()->json([
                    'success' => true,
                    'message' => 'Currency changed successfully.',
                    'currency' => $currency
                ]);
            } else {
                Log::debug('SetCurrencyController - User is not authenticated, setting cookie');
                Cookie::queue('user_currency', $currency, 30 * 24 * 60);

                // Return success response for non-authenticated user
                return response()->json([
                    'success' => true,
                    'message' => 'Currency changed successfully.',
                    'currency' => $currency
                ]);
            }
        } else {
            Log::debug('SetCurrencyController - Invalid Currency', ['currency' => $currency]);

            // Return error response for invalid currency
            return response()->json([
                'success' => false,
                'message' => 'Invalid currency selected.',
            ], 400);  // 400 Bad Request
        }

        // Handle redirect based on previous URL
        $previousUrl = $request->get('previous_url');
        Log::debug('SetCurrencyController - Previous URL', ['previous_url' => $previousUrl]);

        if (!empty($previousUrl)) {
            Log::debug('SetCurrencyController - Redirecting to previous URL');
            return redirect($previousUrl);
        }

        Log::debug('SetCurrencyController - Redirecting back');
        return redirect()->back();
    }
}
