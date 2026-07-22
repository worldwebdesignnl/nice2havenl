<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'privacy_accepted' => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'naam',
            'message' => 'bericht',
            'privacy_accepted' => 'privacyverklaring',
        ];
    }
}
