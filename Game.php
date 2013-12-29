<?php

class Game {
	private $title;
	private $online;
	private $couch;
	private $features = array();
	private $reviewScore;
	private $userRating;
	private $releaseDate;
	private $id;
		
	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getOnline() {
		return $this->online;
	}

	public function setOnline($online) {
		if(is_numeric($online))
			$this->online = $online;
	}

	public function getCouch() {
		return $this->couch;
	}

	public function setCouch($couch) {
		if(is_numeric($couch))
			$this->couch = $couch;
	}

	public function getFeatures() {
		return $this->features;
	}

	public function addFeature($feature) {
		$this->features[] = $feature;
	}

	public function setFeatures($features) {
		$this->features = $features;
	}

	public function getReviewScore() {
		return $this->reviewScore;
	}

	public function setReviewScore($reviewScore) {
		if(is_numeric($reviewScore))
			$this->reviewScore = $reviewScore;
	}

	public function getUserRating() {
		return $this->userRating;
	}

	public function setUserRating($userRating) {
		if(is_numeric($userRating))
			$this->userRating = $userRating;
	}

	public function getReleaseDate() {
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate) {
		$this->releaseDate = $releaseDate;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

}

?>