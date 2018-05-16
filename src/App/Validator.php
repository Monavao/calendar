<?php

namespace App;

use \Datetime;

class Validator
{
	private $data;
	protected $errors = [];

	public function __construct(array $data = [])
	{
		$this->data = $data;
	}

	/**
	 * Check values of data
	 * @param array $data 
	 * @return array | bool
	 */
	public function validates(array $data)
	{
		$this->errors = [];
		$this->data = $data;

		return $this->errors;
	}

	/**
	 * Check if the field is empty
	 * @param string $field 
	 * @param string $method 
	 * @param type ...$parameters 
	 * @return bool
	 */
	public function validate(string $field, string $method, ...$parameters) : bool
	{
		if(!isset($this->data[$field]))
		{
			$this->errors[$field] = "Le champ $fields n'est pas rempli";

			return false;
		}
		else
		{
			return call_user_func([$this, $method], $field, ...$parameters);
		}
	}

	/**
	 * Check if the number of caracters in a field
	 * @param string $field 
	 * @param int $length 
	 * @return bool
	 */
	public function minLength(string $field, int $length) : bool
	{
		if(mb_strlen($this->data[$field]) < $length)
		{
			$this->errors[$field] = "Le champ doit avoir plus de $length caractères";

			return false;
		}

		return true;
	}

	/**
	 * Check if the date is valid
	 * @param string $field 
	 * @return bool
	 */
	public function date(string $field) : bool
	{
		if(Datetime::createFromFormat('Y-m-d', $this->data[$field]) === false)
		{
			$this->errors[$field] = "Date incorrecte";

			return false;
		}	

		return true;
	}

	/**
	 * Check if the time is valid
	 * @param string $field 
	 * @return bool
	 */
	public function time(string $field) : bool
	{
		if(Datetime::createFromFormat('H:i', $this->data[$field]) === false)
		{
			$this->errors[$field] = "Heure incorrecte";

			return false;
		}

		return true;
	}

	/**
	 * Compare two time
	 * @param string $startField 
	 * @param string $endField 
	 * @return bool
	 */
	public function compareTime(string $startField, string $endField) : bool
	{
		if($this->time($startField) && $this->time($endField))
		{
			$start = Datetime::createFromFormat('H:i', $this->data[$startField]);
			$end = Datetime::createFromFormat('H:i', $this->data[$endField]);

			if($start->getTimestamp() > $end->getTimestamp())
			{
				$this->errors[$startField] = "L'heure de début doit être inférieure à l'heure de fin";

				return false;
			}

			return true;
		}

		return false;
	}
}