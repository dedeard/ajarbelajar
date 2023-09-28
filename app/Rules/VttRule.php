<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class VttRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof UploadedFile && $value->isValid()) {
            // Open file and read first line
            $file = fopen($value->getRealPath(), 'r');
            if ($file) {
                $firstLine = fgets($file); // Read the first line
                fclose($file);
                if (trim(strtoupper($firstLine)) == 'WEBVTT') {
                    return;
                }
            }
        }
        $fail("The :attribute must be a valid .vtt file");
    }
}
