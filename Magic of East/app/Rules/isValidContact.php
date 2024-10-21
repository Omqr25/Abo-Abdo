<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class isValidContact implements ValidationRule
{
    protected $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $contact) {
            $validator = Validator::make(['number' => $contact], [
                'number' => ['numeric', 'phone:SY'],
            ]);

            if ($validator->fails()) {
                $fail('The :attribute must contain a valid Contact Number.');
            }

            $records = DB::table($this->table)->get();

            foreach ($records as $record) {
                $numbers = json_decode($record->$attribute, true);

                if (is_array($numbers) && in_array($contact, $numbers)) {
                    $fail('The :attribute must be unique.');
                    return;
                }
            }
        }
    }
}
