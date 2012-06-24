<?php

/**
 * This is the model class for table "global_id".
 *
 * The followings are the available columns in table 'global_id':
 * @property integer $id
 * @property integer $user_id
 * @property integer $news_id
 * @property integer $group_id
 * @property integer $message_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property News $news
 * @property Group $group
 * @property Message $message
 * @property Message[] $messages
 */
class GlobalId extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GlobalId the static model class
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
		return 'global_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, news_id, group_id, message_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, news_id, group_id, message_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'message' => array(self::BELONGS_TO, 'Message', 'message_id'),
			'messages' => array(self::HAS_MANY, 'Message', 'recipent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'news_id' => 'News',
			'group_id' => 'Group',
			'message_id' => 'Message',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('message_id',$this->message_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}