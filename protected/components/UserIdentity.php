<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public function authenticate($days = 0)
    {
        $record = User::model()->findByAttributes(array('nick' => $this->username));
		
        if($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if($record->password !== crypt($this->password, $record->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
			if($days > 99) $days = 99;
			$token = $this->generateToken($days);
			
            $this->_id = $record->id;
            $this->setState('user', $record->id);
			if($days) {
				$record->session_token = $token;
				if($record->save(true, null, true)) {
					$this->setState('token', $token);
				}
			}
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
	
	protected function generateToken($days) {
		$now = date("ymd");
		$random = Randomness::randomString(8);
		$days = sprintf("%02d", $days);
		
		return $now . $days . $random;
	}
}

?>