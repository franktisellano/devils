<?php
	include 'phpQuery.php';

    	const EXTERNAL_URL  = 'http://devils.nhl.com/club/schedule.htm';
	date_default_timezone_set('EST');

	// Initiate phpQuery object
	phpQuery::newDocumentFileHTML(EXTERNAL_URL);
	
	$games = array();
	
	// Hack	
	pq('tr.rwEven, tr.rwOdd')->addClass('hack');
	
	foreach(pq('.hack') as $row)
	{
		// Get the row
		$r = pq($row);
		// Strip unnecessary elements
		$date            = trim($r->find('td:nth-child(1)')->text());
		$time            = trim($r->find('td:nth-child(4)')->text());		
		$visitor         = trim($r->find('td:nth-child(2)')->text());
		$home            = trim($r->find('td:nth-child(3)')->text());
		$network_results = trim($r->find('td:nth-child(5)')->text());
		
		$opponent = ($home == 'Devils') ? $visitor : $home;
		
		// Is game today or tomorrow
		$parsed_date = date_parse($date . ' ' . $time);
		
		
		// Past
		if (date('n') > $parsed_date['month']) {
			$when = 'past';
		} else {
			if (date('n') == $parsed_date['month'] && date('j') > $parsed_date['day']) {
				$when = 'past';
			}
		}
		
		// Future
		if (date('n') < $parsed_date['month']) {
			$when = 'upcoming';
		} else {
			if (date('n') == $parsed_date['month'] && date('j') < $parsed_date['day']) {
				$when = 'upcoming';
			}
		}
		
		// Today
		if (date('n') == $parsed_date['month'] && date('j') == $parsed_date['day']) {
			$when = 'today';
		}
		
		// Tomorrow
		if (date('n') == $parsed_date['month'] && date('j') == $parsed_date['day'] - 1) {
			$when = 'tomorrow';
		}
				
		$game = array(
			'datetime'        => $date . ' ' . $time,
			'gametime'        => $time,
			'opponent'        => $opponent,
			'network_results' => $network_results,
			'when'            => $when
		);
		
		$json_game = $game;
		
		$games []= $game;
	}

	echo json_encode($games);
?>
