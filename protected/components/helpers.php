<?php

function h($in) {
	return CHtml::encode($in);
}

function eh($in) {
	echo CHtml::encode($in), "\n";
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

?>