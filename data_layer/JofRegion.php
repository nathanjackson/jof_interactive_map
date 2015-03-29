<?php

/*
* Class representing a Journey of Faith region.
*/
class  JofRegion implements JsonSerializable {
	private $regionId;
	private $name;
	private $geoJsonStr;

	/**
	* Construct a new JofRegion object.
	*/
	public function __construct($name, $geoJsonStr) {
		$this->regionId = null;
		$this->name = $name;
		$this->geoJsonStr = $geoJsonStr;
	}

	/**
	* Returns the region id.  Null if this object didn't come from the
	* database.
	*/
	public function getRegionId() {
		return $this->regionId;
	}

	/**
	* Returns the region name.
	*/
	public function getName() {
		return $this->name;
	}

	/**
	* Returns the GeoJSON representation of the region.
	*/
	public function getGeoJsonStr() {
		return $this->geoJsonStr;
	}

	/**
	* Sets the region id.
	*/
	public function setRegionId($regionId) {
		$this->regionId = $regionId;
	}

	/**
	* Sets the region name.
	*/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Sets the region's GeoJSON representation.
	*/
	public function setGeoJsonStr($geoJsonStr) {
		$this->geoJsonStr = $geoJsonStr;
	}

	public function jsonSerialize() {
		return [
			'name' => $this->name,
			'geojson' => $this->geoJsonStr
		];
	}
}
