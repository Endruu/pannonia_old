<?php

/**
 * This is the model class for table "global_tag".
 *
 * The followings are the available columns in table 'global_tag':
 * @property integer $gid
 * @property string $cname
 * @property integer $cid
 *
 * The followings are the available model relations:
 * @property Group[] $groups
 * @property Message[] $messages
 * @property Message[] $messages1
 * @property News[] $news
 * @property User[] $users
 */
class GlobalTag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GlobalTag the static model class
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
		return 'global_tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			array('gid, cname, cid', 'safe', 'on'=>'search'),
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
			'group'		=> array(self::HAS_ONE, 'Group',	'gid'),		
			'message'	=> array(self::HAS_ONE, 'Message',	'gid'),
			'news'		=> array(self::HAS_ONE, 'News',		'gid'),
			'user'		=> array(self::HAS_ONE, 'User',		'gid'),
			'messages'	=> array(self::HAS_MANY, 'Message', 'recipent'),
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

		$criteria->compare('gid',$this->gid);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('cid',$this->cid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}