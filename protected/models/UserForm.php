<?php

class UserForm extends CFormModel
{
    public $nick;
    public $name;
    public $email;
	public $password;
	public $password2;
	public $group;
	public $id;
	
	
	public function rules()
    {
        return array(
            array('nick, name, password, password2, email, group', 'required'),
            array('nick', 'length', 'min'=>2, 'max'=>50),
        );
    }
	
	public function attributeLabels()
	{
		return array(
			'name' => 'Teljes név',
			'email' => 'Email',
           	'password' => 'Jelszó',
			'password2' => 'Jelszó újra',
			'nick' => 'Felhasználónév',
		);
	}
	
	
	public function save() {
		$user = new User;
		$user->nick = $this->nick;
		$user->name = $this->name;
		$user->email = $this->email;
		
		if($this->password != $this->password2) {
			$this->addError('password2', 'A jelszavak nem egyeznek!');
			$user->validate();
			$this->addErrors($user->getErrors());
			$this->password = $this->password2 = '';
			return false;
			//seterror
		}
		
		$user->password = crypt($this->password, Randomness::blowfishSalt());
		Yii::trace($this->group, 'userform');
		
		if( $user->save() ) {
			$user->addToGroup($this->group);
			$this->id = $user->id;
			return true;
		} else {
			$this->addErrors($user->getErrors());
			return false;
		}
	}
	
}

?>