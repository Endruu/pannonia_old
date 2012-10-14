<?php

class LoginLog extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'login_log';
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
	
	public static function log($user_id) {
		$log = new LoginLog;
		$log->user_id = $user_id;
		$log->save(false); 
	}
}