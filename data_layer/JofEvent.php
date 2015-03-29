<?php

/*
* Class representing a Journey of Faith event.
*/
class JofEvent implements JsonSerializable {
	private $id;
	private $name;
	private $address;
	private $startDate;
	private $endDate;

	/**
	* Construct a new JofEvent object.  New events have a null ID, as the
	* database assigns IDs automatically.
	*/
	public function __construct($name, $address, $startDate, $endDate) {
		$this->id = null;
		$this->name = $name;
		$this->address = $address;
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
			'startdate' => $this->startDate,
			'enddate' => $this->endDate
		];
	}
}
