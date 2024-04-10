<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WeekDay implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Carbon::parse($value)->isWeekday()) {

            $fail("The {$attribute} must be a weekday.");
        }
    }
}
