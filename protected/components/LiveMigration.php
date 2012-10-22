<?php

class LiveMigration {
	
	public static function run( $to = false ) {
		//get calling action
		$action = Yii::app()->getController()->getAction()->getId();
		
		//load commands
		$commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
		$runner = new CConsoleCommandRunner();
		$runner->addCommands($commandPath);
		$commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
		$runner->addCommands($commandPath);
	
		$migrations = array();	//migrations
		$mresponse = '';		//output of the migrate command
		
		//styling
		echo "<style>td { padding-left: 5px; padding-right: 5px; }</style>\n";
		
		//run yiic migrate to command if parameter provided
		if( $to ) {
			$mresponse .= "<br /><hr /><br />\n";
			$args = array('yiic', 'migrate', 'to', $to, '--interactive=0');
			ob_start();
			$runner->run($args);
			$mresponse .=  preg_replace(
				array("/\n/", "/  /"),
				array("<br />", "&nbsp;&nbsp;"),
				htmlentities(ob_get_clean(), null, Yii::app()->charset)
			);
		}
		
		//get applied migrations
		$args = array('yiic', 'migrate', 'history', '--interactive=0');
		ob_start();
		$runner->run($args);
		$lines = explode("\n", ob_get_clean());
		foreach( $lines as $l) {
			if( preg_match("/\((.*)\)\s*(m(\d\d)(\d\d)(\d\d)_(\d\d)(\d\d)(\d\d)_(.*))/", $l, $m) ) {
				$migrations[$m[2]] = array(
					'applied'	=> $m[1],
					'created'	=> $m[3] . '-' . $m[4] . '-' . $m[5] . ' ' . $m[6] . ':' . $m[7] . ':' . $m[8],
					'name'		=> $m[9],
				);
			}
		}
		$migrations = array_reverse($migrations);
		
		//get pending migrations
		$args = array('yiic', 'migrate', 'new', '--interactive=0');
		ob_start();
		$runner->run($args);
		$lines = explode("\n", ob_get_clean());
		foreach( $lines as $l) {
			if( preg_match("/((m)(\d\d)(\d\d)(\d\d)_(\d\d)(\d\d)(\d\d)_(.*))/", $l, $m) ) {
				$migrations[$m[1]] = array(
					'applied'	=> 'pending',
					'created'	=> $m[3] . '-' . $m[4] . '-' . $m[5] . ' ' . $m[6] . ':' . $m[7] . ':' . $m[8],
					'name'		=> $m[9],
				);
			}
		}
		
		//print page
		echo "
		<table>
			<tr>
				<th>Migration</th>
				<th>Created</th>
				<th>Applied</th>
				<th>Set</th>
			</tr>
		";

		foreach( $migrations as $migration => $m ) {
			$tr = "<tr>";
			$tr .= "<td>" . $m["name"] . "</td>";
			$tr .= "<td>" . $m["created"] . "</td>";
			$tr .= "<td>" . $m["applied"] . "</td>";
			$tr .= "<td>" . CHtml::link("set", array($action, 'to' => $migration)) . "</td>";
			$tr .= "</tr>\n";
			echo $tr;
		}
		
		echo "</table><br />\n" . CHtml::link( "Refresh", array($action) ) . $mresponse;
		
	}

}