<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $created_at
 * @property integer $group
 * @property string $nick
 * @property string $bday
 * @property string $rights
 *
 * The followings are the available model relations:
 * @property GlobalId[] $globals
 * @property Group[] $groups
 * @property Group[] $groups1
 * @property Message[] $messages
 * @property News[] $news
 * @property News[] $news1
 * @property Group $group0
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
			array('name, created_at, nick', 'required'),
			array('group', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>45),
			array('nick', 'length', 'max'=>10),
			array('rights', 'length', 'max'=>1),
			array('bday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, created_at, group, nick, bday, rights', 'safe', 'on'=>'search'),
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
			'globals' => array(self::HAS_MANY, 'GlobalId', 'user_id'),
			'groups' => array(self::HAS_MANY, 'Group', 'leader1'),
			'groups1' => array(self::HAS_MANY, 'Group', 'leader2'),
			'messages' => array(self::HAS_MANY, 'Message', 'sender'),
			'news' => array(self::HAS_MANY, 'News', 'created_by'),
			'news1' => array(self::HAS_MANY, 'News', 'modified_by'),
			'group0' => array(self::BELONGS_TO, 'Group', 'group'),
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
			'created_at' => 'Created At',
			'group' => 'Csoport',
			'nick' => 'Felhasználónév',
			'bday' => 'Születésnap',
			'rights' => 'Rights',
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
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('group',$this->group);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('bday',$this->bday,true);
		$criteria->compare('rights',$this->rights,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}