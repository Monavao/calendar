<?php

namespace Calendar\Date;

use \PDO;
use \Exception;
use \DateTimeImmutable;

class Events
{
	private $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Get elements between two dates
	 * @param \DateTimeImmutable $start
	 * @param \DateTimeImmutable $end
	 * @return Event[]
	 */
	public function getEvents(DateTimeImmutable $start, DateTimeImmutable $end) : array
	{
		$req = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
		$stm = $this->pdo->query($req);
		$stm->setFetchMode(PDO::FETCH_CLASS, Event::class);
		$result = $stm->fetchAll();

		return $result;
	}

	/**
	 * Get elements between two dates by day
	 * @param \DateTimeImmutable $start
	 * @param \DateTimeImmutable $end
	 * @return array
	 */
	public function getEventsByDay(DateTimeImmutable $start, DateTimeImmutable $end) : array
	{
		$events = $this->getEvents($start, $end);
		$days = [];

		foreach ($events as $event)
		{
			$date = $event->getStart()->format('Y-m-d');

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

	/**
	 * Insert event in the database
	 * @param Event $event 
	 * @return bool
	 */
	public function create(Event $event) : bool
	{
		$stm = $this->pdo->prepare("INSERT INTO events (name, description, start, `end`) VALUES(?, ?, ?, ?)");

		return $stm->execute([
			$event->getName(),
			$event->getDescription(),
			$event->getStart()->format('Y-m-d H:i:s'),
			$event->getEnd()->format('Y-m-d H:i:s')
		]);
	}

	/**
	 * Update event in the database
	 * @param Event $event 
	 * @return bool
	 */
	public function update(Event $event) : bool
	{
		$stm = $this->pdo->prepare("UPDATE events SET name = ?, description = ?, start = ?, end = ? WHERE id = ?");

		return $stm->execute([
			$event->getName(),
			$event->getDescription(),
			$event->getStart()->format('Y-m-d H:i:s'),
			$event->getEnd()->format('Y-m-d H:i:s'),
			$event->getId()
		]);
	}

	/**
	 * Delete event in the database
	 * @param Event $event 
	 * @return bool
	 */
	public function delete(Event $event) : bool
	{
		$stm = $this->pdo->prepare("DELETE FROM events WHERE id = ?");

		return $stm->execute([$event->getId()]);
	}

	/**
	 * Inject data
	 * @param Event $event 
	 * @param array $data 
	 * @return Event
	 */
	public function data(Event $event, array $data)
	{
		$event->setName($data['name']);
		$event->setDescription($data['description']);
		$event->setStart(DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format("Y-m-d H:i:s"));
		$event->setEnd(DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format("Y-m-d H:i:s"));

		return $event;
	}
}