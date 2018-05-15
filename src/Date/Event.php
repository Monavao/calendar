<?php

namespace Calendar\Date;

use \Datetime;

class Event
{
	private $id;
	private $name;
	private $description;
	private $start;
	private $end;

	public function getId() : int
	{
		return $this->id;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getDescription() : string
	{
		return $this->description ?? '';
	}

	public function getStart() : Datetime
	{
		return new Datetime($this->start);
	}

	public function getEnd() : Datetime
	{
		return new Datetime($this->end);
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function setDescription(string $description)
	{
		$this->description = $description;
	}

	public function setStart(string $start)
	{
		$this->start = $start;
	}

	public function setEnd(string $end)
	{
		$this->end = $end;
	}
}