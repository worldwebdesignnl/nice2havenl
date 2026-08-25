<?php

namespace App\Http\Requests;

use App\Rules\NoLinks;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255', new NoLinks],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255', new NoLinks],
            'message' => ['required', 'string', 'max:5000', new NoLinks],
            'store_id' => ['nullable', 'exists:stores,id'],
            'privacy_accepted' => ['accepted'],
        ];

        if (config('services.recaptcha.secret_key')) {
            $rules['g-recaptcha-response'] = ['required', new Recaptcha];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'naam',
            'email' => 'e-mailadres',
            'message' => 'bericht',
            'privacy_accepted' => 'privacyverklaring',
            'g-recaptcha-response' => 'verificatie',
        ];
    }
}
