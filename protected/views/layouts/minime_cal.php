<?php
function mCalendar() {
	// Megjelenített év és hónap megadása
	$ma = date("Y-m-d");
	$ev = date('Y'); // 2011
	$ho = date('m'); // 02
	$elozoho = date("Y-m", strtotime("-1 month") );

	
	// Napok neveinek megadása
	$days = array( 'H',  'K',  'Sz',  'Cs',  'P',  'Sz', 'V' );
	// Hónapok neveinek megad�sa
	$months = array(
		'01' => 'Január', 
		'02' => 'Február',
		'03' => 'Március',
		'04' => 'Április',
		'05' => 'Május',
		'06' => 'Június',
		'07' => 'Július',
		'08' => 'Augusztus',
		'09' => 'Szeptember', 
		'10' => 'Október',
		'11' => 'November', 
		'12' => 'December'
	);
	
	// Hónap formátumának beállítása
	$ho = str_pad($ho,  2,  '0',  STR_PAD_LEFT);
	// Első nap pozíciójának meghatározása
	$first = date('N',  strtotime(date("$ev-$ho-01")));
	// Hónap napjainak meghatározása
	$last = date('t',  strtotime("$ev-$ho-01"));
	$prev_last = date('t',  strtotime("$elozoho-01"));
	//echo "PL: $prev_last\n";
	//print date('N',  strtotime(date("$ev-$elozoho-$prev_last"))) . "\n";
	


echo '<div class="minime_cal">' . "\n";
	echo '  <div class="minime_cal_head">' . $months[$ho] . '</div>' . "\n";

		foreach($days as $d) {
			echo '  <div class="minime_cal_week">' . $d . '</div>' . "\n";
		}
		for($i = $prev_last - date('N',  strtotime(date("$elozoho-$prev_last"))) % 7 + 1; $i <= $prev_last; $i++) {
			echo '  <div class="minime_cal_day minime_cal_other">' . $i . '</div>' . "\n";
		}
		for($i = 1; $i <= $last; $i++) {
			$class = 'minime_cal_day';
			if($ma == sprintf("$ev-$ho-%02d", $i)) {
				$class .= ' minime_cal_today';
			}
			echo "  <div class=\"$class\">$i</div>" . "\n";
		}
		for($i = 1; $i <= 7- date('N',  strtotime(date("$ev-$ho-$last"))); $i++) {
			echo '  <div class="minime_cal_day minime_cal_other">' . $i . '</div>' . "\n";
		}
echo '</div>' . "\n";

}
?>
