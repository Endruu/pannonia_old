<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $nick
 * @property string $bday
 * @property string $password
 * @property integer $gid
 * @property string $session_token
 *

 */
class User extends ARwGid
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, nick, email', 'required'),
			array('gid', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>45),
			array('nick', 'length', 'max'=>10),
			array('bday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, nick, bday', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator' => array(self::HAS_MANY, 'GlobalTag', 'created_by'),
			'modifier' => array(self::HAS_MANY, 'GlobalTag', 'modified_by'),
			'groups' => array(self::MANY_MANY, 'Group', 'group_user(user_id, group_id)'),
			'groups1' => array(self::HAS_MANY, 'Group', 'leader2'),	//???
			'messages' => array(self::HAS_MANY, 'Message', 'sender'),
			'gTag' => array(self::BELONGS_TO, 'GlobalTag', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Teljes név',
			'email' => 'Email',
           	'password' => 'Jelszó',
			'nick' => 'Felhasználónév',
			'bday' => 'Születésnap',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('bday',$this->bday,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('session_token',$this->session_token,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function addToGroup($group_id) {
		GroupUserAssoc::saveIfNew($group_id, $this->id);		
	}
}