<?php

class SteamTracker {

	private $_xml, $_success, $_headerCode;

	public function __construct($url) {
		$this->_xml = @simplexml_load_file($url, null, LIBXML_NOCDATA);
		$this->_headerCode = $this->getHeaderCode($url);
		if ($this->_headerCode == 200) {
			$this->_success = true;
		} else {
			$this->_success = false;
		}
	}
	
	public function getGameName() {
		$game = $this->getGame();
		return $game->gameName;
	}
	
	public function getGameLink() {
		$game = $this->getGame();
		return $game->gameLink;
	}
	
	public function getGameLogo() {
		$game = $this->getGame();
		return $game->gameLogo;
	}
	
	// Time played for the last 2 weeks
	public function getTimePlayed() {
		return $this->_xml->stats->hoursPlayed;
	}
	
	public function getAllAchievements() {
		$achievements = $this->_xml->achievements;
		if (count($achievements) > 0) {
			return $achievements->children();
		}
		return null;
	}
	
	public function getNeededAchievements() {
		$achievements = $this->getAllAchievements();
		if ($achievements != null) {
			foreach($achievements as $achievement) {
				if ($achievement['closed'] < 1) {
					$neededAchievements[] = $achievement;
				}
			}
			
			if (!empty($neededAchievements) && is_array($neededAchievements)) {
				return $neededAchievements;
			}
		}
		
		return null;
	}
	
	public function isGameSupported() {
		if (!empty($this->_xml)) {
			return true;
		}
		
		return false;
	}
	
	public function getSuccessStatus() {
		return $this->_success;
	}
	
	public function getHttpCode() {
		return $this->_headerCode;
	}
	
	public static function getBaseUrl() {
		$baseUrl = "http://steamcommunity.com";
		return $baseUrl;
	}
	
	// Private functions
	private function getGame() {
		$game = $this->_xml->game;
		return $game;
	}
	
	private function getHeaderCode($url) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			 CURLOPT_HEADER => true,
			CURLOPT_NOBODY => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url
		));
		$headers = explode("\n", curl_exec( $curl ));
		$httpCode = (int) substr($headers[0], 9, 3);
		return $httpCode;
	}

}

?>