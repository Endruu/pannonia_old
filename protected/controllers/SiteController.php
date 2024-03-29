<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('ensemble');
	}
	
	public function actionGallery()
	{
		$this->render('gallery');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$groups = new CActiveDataProvider('Group');
		$this->render('contact', array( 'groups' => $groups->getData() ) );
	}
	
	public function actionPartners() {
		$this->render('partners');
	}
	
	public function actionEnsemble() {
		$this->render('ensemble');
	}
	
	//csak a migr�ci� idej�re legyen el�rhet�, am�gy kikommentelve
	public function actionMigrate( $to = false ) { LiveMigration::run( $to ); }
	
}