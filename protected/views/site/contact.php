<?php
$this->pageTitle = 'Kapcsolat';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Kapcsolat</h1>
<div class='content'>

	<h2>Próbák</h2>

	<div class="pic_container">
		<img width="150" height="100" src="images/csiga.jpg" alt="Csiga">
		<a href="http://maps.google.hu/maps/ms?msid=208674042497114163641.0004b21968fa9a3216ae8&msa=0&ll=47.547661,19.260235&spn=0.0042,0.009645">
			<img src="http://maps.googleapis.com/maps/api/staticmap?center=47.54693,19.260256&zoom=15&size=150x100&format=gif&markers=color:red|47.547661,19.260235&sensor=false">
		</a>
	</div>

	<?php
		foreach($groups as $g) {
			if($g->rehersals != '???') {
				echo "<h3>$g->name</h3>\n";
				echo "$g->rehersals<br />\n";
			}
		}	
	?>
	
</div>