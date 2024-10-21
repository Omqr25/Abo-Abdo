<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class isValidURL implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $fail('The :attribute must contain valid URLs.');
            }
        }

        // foreach ($value as $url) {
        //     $validator = Validator::make(['url' => $url], [
        //         'url' => 'required|url',
        //     ]);

        //     if ($validator->fails()) {
        //         $fail('The :attribute must contain valid URLs.');
        //     }
        // }
    }
}
