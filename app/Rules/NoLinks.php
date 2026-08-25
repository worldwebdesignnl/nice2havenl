<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoLinks implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value) && preg_match('/https?:\/\/|www\.|\[url=|\[link/i', $value)) {
            $fail('Het :attribute mag geen links bevatten.');
        }
    }
}
