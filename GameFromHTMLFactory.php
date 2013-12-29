<?php

class GameFromHTMLFactory {

  public static function build($rowHTML) {
			$game = new Game();
			
			$game->setId($rowHTML->id);
			
			$game->setTitle(GameFromHTMLFactory::getTitleFromHTML($rowHTML));
			
			$game->setOnline(GameFromHTMLFactory::getOnlineCountFromHTML($rowHTML));
			
			$game->setCouch(GameFromHTMLFactory::getCouchCountFromHTML($rowHTML));
			
			foreach(GameFromHTMLFactory::getFeaturesFromHTML($rowHTML) as $feature) {
				$game->addFeature($feature);
			}
			
			$game->setReviewScore(GameFromHTMLFactory::getReviewScoreFromHTML($rowHTML));
			
			$game->setUserRating(GameFromHTMLFactory::getUserRatingFromHTML($rowHTML));
			
			$game->setReleaseDate(GameFromHTMLFactory::getReleaseDateFromHTML($rowHTML));
			
			return $game;
  }
  
  private static function getTitleFromHTML($html) {  			
  	return $html->find('td strong', 0)->plaintext;
  }
  
  private static function getOnlineCountFromHTML($html) {
  	return $html->find('td', 1)->plaintext;
  }

  private static function getCouchCountFromHTML($html) {
  	return $html->find('td', 2)->plaintext;
  }
  
  private static function getFeaturesFromHTML($html) {
  	
  	$features = array();
  	
  	$featuresHTML = $html->find('td', 3)->find('a');
  	foreach($featuresHTML as $aHTML) {
  		$classes = explode(" ",$aHTML->class);
  		
  		foreach($classes as $class)
  			if($class != 'features-icon')
  				$features[] = $class;
  	}
  	
  	return $features;
  }
  
  private static function getReviewScoreFromHTML($html) {
  	
  	$score = 0;
  	$count = 0;
  	
  	$reviewScoresHTML = $html->find('td', 4)->find('.score-bar div');

  	foreach($reviewScoresHTML as $reviewScoreDiv) {
  		$score += (float) $reviewScoreDiv->plaintext;
  		$count++;
  	}
  	
  	if($count) {
  		$score /= $count;
  		return $score;
  	}
  	
  	return false;
  }
  
  private static function getUserRatingFromHTML($html) {  
	  if($html->find('td', 5)->find('i', 0)) {
	  	$rating = $html->find('td', 5)->find('i', 0)->plaintext;
	  	return preg_replace('#&nbsp;\s?#', '', $rating); 
	  }
	  
	  return false;
  }
  
  private static function getReleaseDateFromHTML($html) {
  	return $html->find('td', 6)->find('em,span', 0)->plaintext;
  }
  
 }

?>