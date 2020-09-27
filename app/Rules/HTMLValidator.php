<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HTMLValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $blacklistArray = ['<script>','alert(','onclick','onload','onmouseover','onmouseout'];
        $valueContent = $value->get();

        foreach ($blacklistArray as $blacklist){
            $matchFound = str_contains($valueContent, $blacklist);
            if ($matchFound)
                return false;
        }
        
        return $value->getClientOriginalExtension() == 'html' ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The file is not a valid HTML mime type or contains non-allowable tag/s';
    }
}
