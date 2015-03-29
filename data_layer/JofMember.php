<?php

/*
* Class representing a Journey of Faith team member.
*/
class JofMember implements JsonSerializable {
	private $memberId;
	private $title;
	private $address;
	private $email;
	private $skills;

	/**
	* Construct a new JofMember object.
	*/
	public function __construct($title, $addr, $email, $skills) {
		$this->memberId = null;
		$this->title = $title;
		$this->address = $addr;
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
			'title' => $this->title,
			'address' => $this->address,
			'email' => $this->email,
			'skills' => $this->skills
		];
	}
}
