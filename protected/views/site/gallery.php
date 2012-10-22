<h1>Családi nap a Simándy-ban</h1>

<?php

$this->beginWidget('galleria');
	
	foreach (glob("images/csaladinap/*.jpg") as $pic) {
		echo "<img src='$pic' />\n";
	}
	
$this->endWidget();

?>
<br />
<a href="images/csaladinap/simandy_csaladi_nap_2012.zip"> Összes letöltése </a>