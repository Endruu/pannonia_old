<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property string $flags
 * @property string $digest
 * @property integer $gid
 *
 * The followings are the available model relations:
 * @property GlobalTag $gTag
 * @property User $author
 * @property User $modifier
 */
class News extends ARwGid
{

	public $text;
	public $author;
	public $created_at;
	public $modifier	= null;
	public $modified_at	= null;
	
	
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
            array('title, digest', 'required'),
            array('gid', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>50),
            array('digest', 'length', 'max'=>32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, digest, gid', 'safe', 'on'=>'search'),
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
            'title' => 'Cím',
            'flags' => 'Flags',
            'digest' => 'Digest',
            'gid' => 'Gid',
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
        $criteria->compare('flags',$this->flags,true);
        $criteria->compare('digest',$this->digest,true);
        $criteria->compare('gid',$this->gid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
					Yii::log("Digest mismatch! ID: $this->id", 'error', 'news');
					$this->text = "<p style='color: red'>Hibás fájl!</p>";
				}
			} else {
				Yii::log("Can't load file! ID: $this->id", 'error', 'news');
				$this->text = "<p style='color: red'>Üres fájl!</p>";
			}
		} else {
			Yii::log("File missing! ID: $this->id", 'error', 'news');
			$this->text = "<p style='color: red'>Hiányzó fájl!</p>";
		}
	}
	
	protected function afterFind()
	{
	
		$this->author		= $this->gTag->creator;
		$this->created_at	= $this->gTag->created_at;
		
		if($this->gTag->modified_by) {
			$this->modifier		= $this->gTag->modifier;
			$this->modified_at	= $this->gTag->modified_at;
		}
	
		if($this->hasEventHandler('onAfterFind'))
			$this->onAfterFind(new CEvent($this));
			
	}
	
}