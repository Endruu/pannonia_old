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
	
	//csak a migráció idejére legyen elérhetõ, amúgy kikommentelve
	public function actionMigrate($down = 0) { $this->runMigrations($down); }
	
	private function runMigrations($down) {
		$commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
		$runner = new CConsoleCommandRunner();
		$runner->addCommands($commandPath);
		$commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
		$runner->addCommands($commandPath);
		$args_history = array('yiic', 'migrate', 'history', '--interactive=0');
		$args_migrate = $down ? array('yiic', 'migrate', 'down', $down, '--interactive=0') : array('yiic', 'migrate', '--interactive=0');
		ob_start();
		$runner->run($args_history);
		$runner->run($args_migrate);
		echo preg_replace(
			array("/\n/", "/  /"),
			array("<br />", "&nbsp;&nbsp;"),
			htmlentities(ob_get_clean(), null, Yii::app()->charset)
		);
		
	}
	
}