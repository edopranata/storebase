<?php

namespace App\Rules;

use App\Models\Adjustment;
use Illuminate\Contracts\Validation\InvokableRule;

class IfExists implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $adjustment = Adjustment::query()
            ->whereNull('status')->get();
        if($adjustment->count()){
            $fail('Masih ada pending stock opname / stock adjustment yang belum selesai');
        }
    }
}
