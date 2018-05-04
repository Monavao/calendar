<?php

namespace Calendar\Date;

use \PDO;

class Events
{
	/**
	 * Get elements between two dates
	 * @param \DateTime $start 
	 * @param \Datetime $end 
	 * @return array
	 */
	public function getEvents(\DateTime $start, \Datetime $end) : array
	{
		$pdo = new PDO('mysql:host=localhost;dbname=calendar', 'root', 'root',[
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);

		$req = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
		$statement = $pdo->query($req);
		$result = $statement->fetchAll();

		//var_dump($req);

		return $result;
	}

	/**
	 * Get elements between two dates by day
	 * @param \DateTime $start 
	 * @param \Datetime $end 
	 * @return array
	 */
	public function getEventsByDay(\DateTime $start, \Datetime $end) : array
	{
		$events = $this->getEvents($start, $end);
		$days = [];

		foreach ($events as $event)
		{
			$date = explode('', $event[start])[0];

			if(!isset($days[$date]))
			{
				$days[$date] = [$event];
			}
			else
			{
				$days[$date][] = $event;
			}
		}
	}
}