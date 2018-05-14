<?php

namespace Calendar\Date;

use App\Validator;

class InputValidator extends Validator
{
	/**
	 * Check values of data
	 * @param array $data 
	 * @return array|bool
	 */
	public function validates(array $data)
	{
		parent::validates($data);
		$this->validate('name', 'minLength', 3);

		return $this->errors;
	}
}