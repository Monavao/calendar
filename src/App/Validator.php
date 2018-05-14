<?php

namespace App;

class Validator
{
	private $data;
	protected $errors = [];

	/**
	 * Check values of data
	 * @param array $data 
	 * @return array|bool
	 */
	public function validates(array $data)
	{
		$this->errors = [];
		$this->data = $data;
	}

	public function validate(string $fields, string $method, ...$parameters)
	{
		if(!isset($this->data[$fields]))
		{
			$this->errors[$fields] = "Le champ {$fields} n'est pas rempli";
		}
		else
		{
			call_user_func([$this, $method], $field, ...$parameters);
		}
	}

	public function minLength(string $field, int $length)
	{
		if(nb_strlen($field) < $length)
		{
			$this->errors[$field] = "Le champ doit avoir plus de {$length} caractères";
		}
	}
}