<?php

	if(Yii::app()->user->isGuest) {
		$redirect = $this->pageTitle == 'Új felhasználó' ? true : false;
			
	
		echo CHtml::ajaxLink(
			'Bejelentkezés',
			array( 'session/login', array('redirect' => $redirect) ),
			array( 'update' => '#session-control' ),
			array( 'class'=>'main' )
		);
		br();
		echo CHtml::link(
			'Regisztráció',
			array( 'user/create' ),
			array( 'class' => 'sub', )
		);
	}
	else {
		echo CHtml::link(
			Yii::app()->user->name,
			array( 'user/view', 'id' => Yii::app()->user->id ),
			array( 'class' => 'main', )
		);
		br();
		echo CHtml::ajaxLink(
			'Kijelentkezés',
			array( 'session/logout' ),
			array( 'update' => '#session-control' ),
			array( 'class' => 'sub', )
		);
	}

?>

<div id="session-holder"></div>