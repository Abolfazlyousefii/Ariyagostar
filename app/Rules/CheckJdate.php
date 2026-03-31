<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Morilog\Jalali\Jalalian;

class CheckJdate implements Rule
{
    private $format = 'Y-m-d';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($format = null)
    {
        if ($format) {
            $this->format = $format;
        }
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
        $value = convertPersianToEnglish($value);

        try {
            Jalalian::fromFormat($this->format, $value);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'فرمت تاریخ نامعتبر است';
    }
}
