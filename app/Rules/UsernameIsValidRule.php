<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameIsValidRule implements Rule
{
	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		// Skip null value or empty string
		// Use Laravel 'required' rule for that
		if ($value == '') {
			return true;
		}
		
		$value = trim(strtolower($value));
		
		if ($this->hasInvalidCharacter($value)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return trans('validation.username_is_valid_rule');
	}
	
	/* PRIVATES */
    
    /**
     * Determine whether the given username contains a non-alphanumeric character
	 * or only numeric characters (to prevent a phone number field).
     *
     * @param $value
     * @return bool
     */
    private function hasInvalidCharacter($value)
    {
		if (!ctype_alnum($value) || is_numeric($value)) {
            return true;
        }

        return false;
    }
}
