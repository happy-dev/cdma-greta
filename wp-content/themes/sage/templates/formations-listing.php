<?php
// DATES DE SESSION
 // If multiple sessions
    if ($ms) {
    	foreach ($ss as $s) {
    		$sd = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
    		$ed = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
    		echo '<div>' ;
    		echo 'Du '.$sd.' au '.$ed ; 	// dates de session
			echo $dc ;						// commentaire de date
			echo '</div>' ;
    	}
    }
// If single session
    else { 
		if ($sd) {
		echo 'Du '.$sd.' au '.$ed ; 	// dates de session
		}
		echo $dc ;						// commentaire de date
    }
?>