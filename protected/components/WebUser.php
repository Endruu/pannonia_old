<?php

class WebUser extends CWebUser
{

protected function beforeLogin($id,$states,$fromCookie)
{
	Yii::trace('login', 'session');
	if($fromCookie) {
		Yii::trace('cookie', 'session');
		if(isset($states['token'])) {
			Yii::trace('token', 'session');
			$user = User::model()->findByAttributes(array('id' => $id));
			Yii::trace('s:' . $states['token'] . "\nu:" . $user->session_token, 'session');
			if($states['token'] == $user->session_token) {
				
				return true;
			}
		}
		
		return false;
	}

	return true;
}

}

?>