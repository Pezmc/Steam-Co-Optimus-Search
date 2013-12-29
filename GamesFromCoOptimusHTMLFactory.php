<?php

class GamesFromCoOptimusHTMLFactory {

	/**
	 * @param unknown $cooptimusHTML
	 * @return Game[]
	 */
  public static function build($cooptimusHTML) {
  	
  		$html = str_get_html($cooptimusHTML);
  		if(!$html) return;
  	
  		// Games
			$games = array();
		
			// Find all the lists
			foreach($html->find('table[id=results_table] tr[class=result_row]') as $row) {	
				$games[] = GameFromHTMLFactory::build($row);
			}
			
			return $games;
  }
   
 }

?>