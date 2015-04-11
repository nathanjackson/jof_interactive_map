<?php

/*
* Class representing a Journey of Faith event.
*/
class JofEvent implements JsonSerializable {
	private $id;
	private $name;
	private $address;
	private $latdeg;
	private $londeg;
	private $startDate;
	private $endDate;

	/**
	* Construct a new JofEvent object.  New events have a null ID, as the
	* database assigns IDs automatically.
	*/
	public function __construct($name, $address, $latdeg, $londeg, $startDate, $endDate) {
		$this->id = null;
		$this->name = $name;
		$this->address = $address;
		$this->latdeg = $latdeg;
		$this->londeg = $londeg;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}

	/**
	* Returns the event id.  Null if the JofEvent object did not come from
	* the database.
	*/
	public function getEventId() {
		return $this->id;
	}

	/**
	* Returns the event name.
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Returns the event address.
	*/
	public function getAddress() {
		return $this->address;
	}

	/**
	* Returns the event latitude.
	*/
	public function getLatDeg() {
		return $this->latdeg;
	}

	/**
	* Returns the event longitude.
	*/
	public function getLonDeg() {
		return $this->londeg;
	}

	/**
	* Returns the event start date.
	*/
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	* Returns the event end date.
	*/
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	* Set the event ID.
	*/
	public function setEventId($id) {
		$this->id = $id;
	}

	/**
	* Set the event name.
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Set the event address.
	*/
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	* Set the event latitude.
	*/
	public function setLatDeg($latdeg) {
		$this->latdeg = $latdeg;
	}

	/**
	* Set the event longitude.
	*/
	public function setLonDeg($londeg) {
		$this->londeg = $londeg;
	}

	/**
	* Set the start date.
	*/
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}

	/**
	* Set the end date.
	*/
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
	}

	public function jsonSerialize() {
		return [
			'name' => $this->name,
			'address' => $this->address,
			'latdeg' => $this->latdeg,
			'londeg' => $this->londeg,
			'startdate' => $this->startDate,
			'enddate' => $this->endDate
		];
	}
}
