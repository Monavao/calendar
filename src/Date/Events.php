<?php

namespace Calendar\Date;

use \PDO;
use \Exception;

class Events
{
	private $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Get elements between two dates
	 * @param \DateTime $start
	 * @param \Datetime $end
	 * @return array
	 */
	public function getEvents(\DateTime $start, \Datetime $end) : array
	{
		$req = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
		$stm = $this->pdo->query($req);
		$result = $stm->fetchAll();

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
			$date = explode(' ', $event['start'])[0];

			if(!isset($days[$date]))
			{
				$days[$date] = [$event];
			}
			else
			{
				$days[$date][] = $event;
			}
		}

		return $days;
	}

	/**
	 * Get an event
	 * @param int $id 
	 * @return Event
	 * @throws \Exception
	 */	
	public function find(int $id) : Event
	{
		require 'Event.php';
		$stm = $this->pdo->query("SELECT * FROM events WHERE id = $id");
		$stm->setFetchMode(PDO::FETCH_CLASS, Event::class);
		$result = $stm->fetch();

		if($result === false)
		{
			throw new Exception('Aucun résultat trouvé');
		}

		return $result;
	}
}