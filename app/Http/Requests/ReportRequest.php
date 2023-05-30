<?php


namespace App\Http\Requests;

use App\Rules\BetweenRule;
use App\Rules\EmailRule;

class ReportRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'report_type_id' => ['required', 'not_in:0'],
			'email'          => ['required', 'email', new EmailRule(), 'max:100'],
			'message'        => ['required', new BetweenRule(20, 1000)],
		];
		
		return $this->captchaRules($rules);
	}
}
