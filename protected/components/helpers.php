<?php

function h($in) {
	return CHtml::encode($in);
}

function eh($in) {
	echo CHtml::encode($in), "\n";
}

function br() {
	echo "<br />\n";
}

function wSplit($string, $maxlength) {
    $string = substr($string, 0, $maxlength+1);
    if(preg_match('/\s$/', $string) == 1) {
        $string = preg_replace('/\s+$/', '', $string);
    } else {
        $string = preg_replace("/\s+\S+$/", "", $string);

    }
    return $string;
}

function subNavigator($link_hash, $current = false, $class = '', $width = 100) {
	if(is_string($link_hash)) {
		$link_hash = Yii::app()->params[$link_hash];
	}
	echo "<table class='subnavigator $class'>\n  <tr>\n";
	foreach ($link_hash as $key => $link) {
		if($current && $current == $key) {
			echo "    <td width='$width'>", CHtml::link($key, $link, array('class' => 'current') ), "</td>\n";
		} else {
			echo "    <td width='$width'>", CHtml::link($key, $link ), "</td>\n";
		}
	}
	echo "  <tr>\n</table>\n";
}

?>