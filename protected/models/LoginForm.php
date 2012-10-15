<?php

class LoginForm extends CFormModel
{
    public $nick;
	public $password;
	
	public function rules()
    {
        return array(
            array('nick, password', 'required'),
            //array('nick', 'length', 'min'=>2, 'max'=>50),
			array('redirect', 'safe'),
        );
    }
	
	public function attributeLabels()
	{
		return array(
           	'password' => 'Jelszó',
			'nick' => 'Felhasználónév',
		);
	}
	
}

?>