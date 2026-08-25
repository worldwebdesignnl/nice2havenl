<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        if (! $secret) {
            return;
        }

        $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ])->json();

        $minScore = (float) config('services.recaptcha.min_score', 0.5);

        if (! ($result['success'] ?? false) || ($result['score'] ?? 0) < $minScore) {
            $fail('We konden niet verifiëren dat je geen robot bent. Vernieuw de pagina en probeer het opnieuw.');
        }
    }
}
