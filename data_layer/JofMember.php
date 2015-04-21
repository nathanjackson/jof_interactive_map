<?php

/*
* Class representing a Journey of Faith team member.
*/
class JofMember implements JsonSerializable {
	private $memberId;
	private $title;
	private $address;
	private $latDeg;
	private $lonDeg;
	private $email;
	private $skills;

	/**
	* Construct a new JofMember object.
	*/
	public function __construct($title, $addr, $latDeg, $lonDeg, $email, $skills) {
		$this->memberId = null;
		$this->title = $title;
		$this->address = $addr;
		$this->latDeg = $latDeg;
		$this->lonDeg = $lonDeg;
		$this->email = $email;
		$this->skills = $skills;
	}

	/**
	* Gets the member id.  Returns an integer if the object came from the
	* database, otherwise null.
	*/
	public function getMemberId() {
		return $this->memberId;
	}

	/**
	* Gets the member title.
	*/
	public function getTitle() {
		return $this->title;
	}

	/**
	* Gets the member address.
	*/
	public function getAddress() {
		return $this->address;
	}

	/**
	* Gets the member latitude.
	*/
	public function getLatDeg() {
		return $this->latDeg;
	}

	/**
	* Gets the member longitude.
	*/
	public function getLonDeg() {
		return $this->lonDeg;
	}

	/**
	* Gets the member email.
	*/
	public function getEmail() {
		return $this->email;
	}

	/**
	* Gets the member's skillset.
	*/
	public function getSkills() {
		return $this->skills;
	}

	/**
	* Sets the member's id.
	*/
	public function setMemberId($id) {
		$this->memberId = $id;
	}

	/**
	* Sets the member's title.
	*/
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	* Sets the member's address.
	*/ 
	public function setAddress($addr) {
		$this->address = $addr;
	}

	/**
	* Sets the member's latitude.
	*/
	public function setLatDeg($latDeg) {
		$this->latDeg = $latDeg;
	}

	/**
	* Sets the member's longitude.
	*/
	public function setLonDeg($lonDeg) {
		$this->lonDeg = $lonDeg;
	}

	/**
	* Set the member's email.
	*/
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	* Set the member's skills.
	*/
	public function setSkills($skills) {
		$this->skills = $skills;
	}

	public function jsonSerialize() {
		return [
			'id' => $this->memberId,
			'title' => $this->title,
			'address' => $this->address,
			'latdeg' => $this->latDeg,
			'londeg' => $this->lonDeg,
			'email' => $this->email,
			'skills' => $this->skills
		];
	}
}
