<?php

/**
 * This is the model class for table "global_tag".
 *
 * The followings are the available columns in table 'global_tag':
 * @property integer $gid
 * @property string $cname
 * @property integer $cid
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User $modifiedBy
 * @property Group[] $groups
 * @property Message[] $messages
 * @property Message[] $messages1
 * @property News[] $news
 * @property User[] $users
 */
class GlobalTag extends CActiveRecord
{

	// flags osztály, csak nem lehet belsõ osztály
	
	private $_valid		= 2;
	private $_deleted	= 4;
	private $_draft		= 8;

	public $valid	= true;
	public $deleted	= false;
	public $draft	= false;
	
	public function decodeFlags($char) {
		if(!$char) return;	//ha nincs érvényes mentett, akkor maradnak az alapértékek
		
		$this->valid	= ($char & $this->_valid)	? true : false;
		$this->deleted	= ($char & $this->_deleted)	? true : false;
		$this->draft	= ($char & $this->_draft)	? true : false;
	}
	
	public function encodeFlags() {
		$char = chr(1);		//érvényes flag
		
		if($this->valid)	$char |= chr($this->_valid);
		if($this->deleted)	$char |= chr($this->_deleted);
		if($this->draft)	$char |= chr($this->_draft);
		
		return $char;
	}
	
	//end of flags
	
	
	
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
		return array(
			array('gid, cname, cid, created_at, modified_at, created_by, modified_by, flagchar', 'safe'),
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
			'creator'	=> array(self::BELONGS_TO, 'User', 'created_by'),
			'modifier'	=> array(self::BELONGS_TO, 'User', 'modified_by'),
			'recipent'	=> array(self::HAS_MANY, 'Message', 'recipent'),
			'g_group'	=> array(self::HAS_MANY, 'Group', 'gid'),
			'g_message'	=> array(self::HAS_MANY, 'Message', 'gid'),
			'g_news'	=> array(self::HAS_MANY, 'News', 'gid'),
			'g_user'	=> array(self::HAS_MANY, 'User', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gid' => 'Gid',
			'cname' => 'Cname',
			'cid' => 'Cid',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
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
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function afterFind()
	{
		$this->decodeFlags($this->flagchar);
	
		if($this->hasEventHandler('onAfterFind'))
			$this->onAfterFind(new CEvent($this));
	}
	
	protected function beforeSave()
	{
		$this->flagchar = $this->encodeFlags();
	
		if($this->hasEventHandler('onBeforeSave'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeSave($event);
			return $event->isValid;
		}
		else
			return true;
	}
	
}