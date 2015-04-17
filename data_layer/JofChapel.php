<?php

/*
* Class representing a CWOC chapel.
*/
class JofChapel implements JsonSerializable {
	private $id;
	private $address;
	private $latdeg;
	private $londeg;
	private $installation;
	private $name;
	private $cwocEmail;
	private $phoneNumber;
	private $parishCoordEmail;

	/**
	* Construct a new JofChapel object.
	*/
	public function __construct($addr, $latdeg, $londeg, $installation,
		$name, $cwocEmail, $phoneNumber, $parishCoordEmail) {
		$this->id = null;
		$this->address = $addr;
		$this->latdeg = $latdeg;
		$this->londeg = $londeg;
		$this->installation = $installation;
		$this->name = $name;
		$this->cwocEmail = $cwocEmail;
		$this->phoneNumber = $phoneNumber;
		$this->parishCoordEmail = $parishCoordEmail;
	}

	/**
	* Gets the chapel id.  Returns an integer if the object came from the
	* database, otherwise null.
	*/
	public function getChapelId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	/**
	* Gets the chapel address.
	*/
	public function getAddress() {
		return $this->address;
	}

	/**
	* Gets the chapel latitude.
	*/
	public function getLatDeg() {
		return $this->latdeg;
	}

	/**
	* Gets the chapel longitude.
	*/
	public function getLonDeg() {
		return $this->londeg;
	}

	/**
	* Gets the chapel's CWOC email address.
	*/
	public function getCwocEmail() {
		return $this->cwocEmail;
	}

	/**
	* Gets the chapel's phone number.
	*/
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}

	/**
	* Gets the chapel's parish coordinator email.
	*/
	public function getParishCoordEmail()
	{
		return $this->parishCoordEmail;
	}

	/**
	* Sets the chapel's id.
	*/
	public function setChapelId($id) {
		$this->chapelId = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Sets the chapel's installation name.
	*/
	public function setInstallation($installation) {
		$this->installation = $installation;
	}

	/**
	* Sets the chapel's address.
	*/ 
	public function setAddress($addr) {
		$this->address = $addr;
	}

	/**
	* Sets the chapel's latitude.
	*/
	public function setLatDeg($latdeg) {
		$this->latdeg = $latdeg;
	}

	/**
	* Sets the chapel's longitude.
	*/
	public function setLonDeg($londeg) {
		$this->londeg = $londeg;
	}

	/**
	* Set the chapel's cwoc email.
	*/
	public function setEmail($cwocEmail) {
		$this->cwocEmail = $cwocEmail;
	}

	/**
	* Set the chapel's phone number.
	*/
	public function setPhoneNumber($phone) {
		$this->phoneNumber = $phone;
	}

	/**
	* Set the chapel's parish coordinator email.
	*/
	public function setParishCoordEmail($parishCoordEmail) {
		$thos->parishCoordEmail = $parishCoordEmail;
	}

	public function jsonSerialize() {
		return [
			'id' => $id,
			'address' => $address,
			'latdeg' => $latdeg,
			'londeg' => $londeg,
			'installation' => $installation,
			'name' => $name,
			'cwocEmail' => $cwocEmail;
			'phoneNumber' => $phoneNumber,
			'parishCoordEmail' => $parishCoordEmail
		];
	}
}
