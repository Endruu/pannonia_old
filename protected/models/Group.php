<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $rehersals
 * @property integer $leader1
 * @property integer $leader2
 * @property string $image
 * @property integer $gid
 *
 * The followings are the available model relations:
 * @property GlobalTag $gTag
 * @property User $leader10
 * @property User $leader20
 * @property User[] $users
 */
class Group extends ARwGid
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Group the static model class
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
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, rehersals, leader1', 'required'),
			array('leader1, leader2', 'numerical', 'integerOnly'=>true),
			array('name, rehersals', 'length', 'max'=>45),
			array('image', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, rehersals, leader1, leader2, image', 'safe', 'on'=>'search'),
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
			'gTag'		=> array(self::BELONGS_TO, 'GlobalTag', 'gid'),
			'r_leader1' => array(self::BELONGS_TO, 'User', 'leader1'),
			'r_leader2' => array(self::BELONGS_TO, 'User', 'leader2'),
            'users' => array(self::MANY_MANY, 'User', 'group_user(group_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'rehersals' => 'Rehersals',
			'leader1' => 'Leader1',
			'leader2' => 'Leader2',
			'image' => 'Image',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('rehersals',$this->rehersals,true);
		$criteria->compare('leader1',$this->leader1);
		$criteria->compare('leader2',$this->leader2);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getGroups($full = false) {
		$criteria = new CDbCriteria;
		$criteria->compare('id', '< 10');
		
		$dp = new CActiveDataProvider('Group', array( 'criteria'=>$criteria ));
		
		$groups = $dp->getData();
		if($full) return $groups;
		
		$return = array();
		foreach($groups as $g) {
			$return[$g->id] = $g->name;
		}
		
		return $return;
	}
	
	public function addUser($user_id) {
		GroupUserAssoc::saveIfNew($this->id, $user_id);		
	}
}