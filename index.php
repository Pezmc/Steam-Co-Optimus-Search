<?php

require("SteamAPI.class.php");

require("simple_html_dom.php");

require("Game.php");
require("GameFromHTMLFactory.php");
require 'GamesFromCoOptimusHTMLFactory.php';
		
		//////////
		
		function getCachedFileOrFalse($cache_file, $time=3600) {
		
			if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $time ))) {
				return file_get_contents($cache_file);
			} else {
				return false;
			}
		}
		
		/**
		 * Download a url or get it from the cache
		 */
		function getCachedURL($url, $cache_file=null, $time=3600) {
		
			// Choose the cache filename and folder
			if(!$cache_file) $cache_file = md5($url).'.txt';
			$cache_file = 'cache/'.$cache_file;
		
			$data = getCachedFileOrFalse($cache_file, $time);
		
			if(!$data) {
				$data = file_get_contents($url);
				file_put_contents($cache_file, $data, LOCK_EX);
			}
		
			return $data;
		}
		

		function getCoOptimusPC($page) {
		
			// Download the page
			$timetablesHTML = getCachedURL("http://www.co-optimus.com/ajax/ajax_games.php?system=4&countDirection=at%20least&playerCount=2&page=$page");
			
			$games = GamesFromCoOptimusHTMLFactory::build($timetablesHTML);
		
			return $games;
		}
		
		$cacheFile = 'cache/allgames.txt';
		$allGames = getCachedFileOrFalse($cacheFile);
		if(!$allGames) {		
			$allGames = array();
			
			for($i=1; $i <= 21; $i++) {
				foreach(getCoOptimusPC($i) as $game)
					$allGames[] = $game;
			}
			
			file_put_contents($cacheFile, serialize($allGames));
		} else {
			$allGames = unserialize($allGames);
		}
		
if(empty($_GET['id'])) {
	$id = "k3yl3ss";
}
$steam = new SteamAPI($id);

$stringEditDistanceThreshold = 5; // greater than this means rejected



foreach($steam->getGames() as $game) {
	
	/* @var $match Game */
	$match = findClosestMatchingGame($game['name'], $allGames);
	if($match)
		echo "Matched " . $match->getTitle() . "\n";
	/*else
		echo "Failed to match " . $game['name'] . "\n";*/
	
	/* @var $coopGame Game */
	/*foreach($allGames as $coopGame) {
		if(strtolower($coopGame->getTitle()) == strtolower($game['name']))
			echo $game['name'] . "\n";
		else {
			if(substr($game['name'], 0, 10) == substr($coopGame->getTitle(), 0, 10))
				echo $game['name'] . ' != ' . $coopGame->getTitle() . "\n";		
		}
	}*/
}


// define the mapping function
function findClosestMatchingGame($s, $array) {
	$closestDistanceThusFar = 5;
	$closestMatchValue      = null;

	/* @var $game Game */
	foreach ($array as $game) {
		$editDistance = levenshtein(strtolower($game->getTitle()), strtolower($s));

		// exact match
		if ($editDistance == 0) {
			return $game;

			// best match thus far, update values to compare against/return
		} elseif ($editDistance < $closestDistanceThusFar) {
			$closestDistanceThusFar = $editDistance;
			$closestMatchValue      = $game;
		}
	}

	return $closestMatchValue; // possible to return null if threshold hasn't been met
}
		