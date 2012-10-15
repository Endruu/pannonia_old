<?php

class SessionController extends Controller
{
	public function actionLogin()
	{
		$model = new LoginForm;

		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			
			Yii::trace(CVarDumper::dumpAsString($model), 'session');
			
			$identity = new UserIdentity($model->nick,$model->password);
			if($identity->authenticate(7)) {
				Yii::trace('login auth', 'session');
				Yii::app()->user->login($identity, 3600*24*7);
				LoginLog::log(Yii::app()->user->id);
			}
			else {
				echo $identity->errorMessage;
			}
			
		}
		
		if(Yii::app()->user->isGuest) {
			Yii::trace('login render', 'session');
			$this->renderPartial('login', array('model' => $model), false, true);
		} else {
			$this->renderPartial('view', null, false , true);
		}
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->renderPartial('view', null, false, true);
	}

	public function actionView()
	{
		$this->render('view');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}