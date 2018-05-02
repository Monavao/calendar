<?php

namespace Calendar\Date;

//use Exception;

class Month
{
	public $days = [
		'Lundi',
		'Mardi',
		'Mercredi',
		'Jeudi',
		'Vendredi',
		'Samedi',
		'Dimanche'
	];

	private $months = [
		'Janvier', 
		'Février', 
		'Mars', 
		'Avril', 
		'Mai', 
		'Juin', 
		'Juillet', 
		'Août', 
		'Septembre', 
		'Octobre', 
		'Novembre', 
		'Décembre'
	];

	public $month;
	public $year;

	/**
	 * Month's constructor
	 * @param int $month between 1 and 12
	 * @param int $year 
	 * @throws Exception
	 */
	public function __construct(?int $month = null, ?int $year = null)
	{
		if($month === null || $month < 1 || $month > 12)
		{
			$month = intval(date('m'));
		}

		if($year === null)
		{
			$year = intval(date('Y'));
		}

		/*
		if($month < 1 || $month > 12)
		{
			throw new Exception('Invalid month');
		}
		*/

		$this->month = $month;
		$this->year = $year;
	}

	/**
	 * Return first day of the month
	 * @return \Datetime
	 */
	public function getFirstDay() : \DateTime
	{
		return new \DateTime("{$this->year}-{$this->month}-01");
	}

	/**
	 * Return the month in a string
	 * @return string
	 */
	public function toString() : string
	{
		return $this->months[$this->month - 1] . ' ' . $this->year;
	}

	/**
	 * Return number of weeks in a month
	 * @return integer
	 */
	public function getWeeks() : int
	{
		$start = $this->getFirstDay();
		$end = (clone $start)->modify('+1 month -1 day');

		//var_dump($end->format('W'), $start->format('W'));
		
		$weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

		if($weeks < 0)
		{
			$weeks = intval($end->format('W'));
		}

		return $weeks;
	}

	/**
	 * Return true if days is in currently month
	 * @param \Datetime $date 
	 * @return bool
	 */
	public function inMonth(\Datetime $date) : bool
	{
		return $this->getFirstDay()->format('Y-m') === $date->format('Y-m');
	}

	/**
	 * Return the next month and the next year if necessary
	 * @return Month
	 */
	public function nextMonth() : Month
	{
		$month = $this->month + 1;
		$year = $this->year;

		if($month > 12)
		{
			$month = 1;
			$year += 1;
		}

		return new Month($month, $year);
	}

	/**
	 * Return the previous month and the previous year if necessary
	 * @return Month
	 */
	public function previousMonth() : Month
	{
		$month = $this->month - 1;
		$year = $this->year;

		if($month < 1)
		{
			$month = 12;
			$year -= 1;
		}

		return new Month($month, $year);
	}
}