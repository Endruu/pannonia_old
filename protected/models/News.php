<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $flags
 * @property string $digest
 *
 * The followings are the available model relations:
 * @property GlobalId[] $globals
 * @property User $createdBy
 * @property User $modifiedBy
 */
class News extends CActiveRecord
{

	public $text;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, created_at, created_by, digest', 'required'),
			array('created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('flags', 'length', 'max'=>1),
			array('digest', 'length', 'max'=>32),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, created_at, modified_at, created_by, modified_by, flags, digest', 'safe', 'on'=>'search'),
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
			'globals' => array(self::HAS_MANY, 'GlobalId', 'news_id'),
			'author' => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifier' => array(self::BELONGS_TO, 'User', 'modified_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
			'flags' => 'Flags',
			'digest' => 'Digest',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('flags',$this->flags,true);
		$criteria->compare('digest',$this->digest,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	private $flag_fields = array(
		'FVALID'	=> 0,
		'FMISSING'	=> 1,
		'DRAFT'		=> 7,
	);
	
	public function initFlags() {
		$this->setFlags( array (
			'FVALID'	=> true,
			'FMISSING'	=> true,
			'DRAFT'		=> true,
		));
	}
	
	public function setFlags($flags) {
		foreach( array_keys($flags) as $flag ) {
			if( array_key_exists($flag, $this->flag_fields) ) {
				if( $flags[$flag] ) {
					$this->flags |= chr(pow(2,$this->flag_fields[$flag]));
				} else {
					$this->flags &= ~chr(pow(2,$this->flag_fields[$flag]));
				}
			}
		}
		
	}
	
	public function getFlags($which = false) {
		if($which) {
			if( array_key_exists($which, $this->flag_fields) ) {
				if( $this->flags & pow(2, $this->flag_fields[$which]) ) {
					return true;
				} else {
					return false;
				}
			} else {
				return null;
			}
		} else {
			$ret = array();
			foreach( array_keys($this->flag_fields) as $flag ) {
				if( $this->flags & pow(2, $this->flag_fields[$flag]) ) {
					$ret[$flag] = true;
				} else {
					$ret[$flag] = false;
				}
			}
			return $ret;
		}
	}
	
	public function loadText()
	{
		$file = Yii::app()->params['news_path'] . '/' . $this->id . ".txt";
		if(file_exists($file)) {
			if( $text = file_get_contents($file) ) {
				$digest = md5($text);
				if($digest == $this->digest) {
					$this->text = $text;
				} else {
					Yii::log("Digest mismatch!", 'error', 'news');
					$this->text = "<p style='color: red'>Hibás fájl!</p>";
				}
			} else {
				Yii::log("Can't load file!", 'error', 'news');
				$this->text = "<p style='color: red'>Üres fájl!</p>";
			}
		} else {
			Yii::log("File missing!", 'error', 'news');
			$this->text = "<p style='color: red'>Hiányzó fájl!</p>";
		}
	}
}