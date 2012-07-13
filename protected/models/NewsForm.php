<?php

class NewsForm extends CFormModel
{
    public $user;
    public $title;
    public $text;
	private $sanitized = false;
	
	public function rules()
    {
        return array(
            array('title, text', 'required'),
            array('title', 'length', 'min'=>2, 'max'=>50),
			array('text', 'textValidator'),
        );
    }
	
	public function textValidator($attribute,$params)
    {
        if( preg_match("/<\?/", $this->text) || preg_match("/\?>/", $this->text) ) {
            $this->addError('text','PHP text!');
		} elseif ( preg_match("/<\s*\/?script[^>]*>/", $this->text) ) {
			$this->addError('text','JS text!');
		}

    }
	
	public function sanitizeText()
	{
		if($this->text) {
			$this->text = filter_var($this->text, FILTER_SANITIZE_SPECIAL_CHARS);
			$this->sanitized = true;
		}
	}
	
	public function save($sanitized = false)
	{
		if($sanitized) {
			$this->sanitizeText();
		}
		
		$save_path = Yii::app()->params['news_path'];
		Yii::trace($save_path, 'news');
		
		if( file_put_contents( "$save_path/_temp.txt", $this->text ) ) {
			$digest = md5( $this->text );
			$model = new News;
			$model->setAttributes( array(
				'title'		 => $this->title,
				'digest'	 => $digest,
				'created_by' => 1, //$this->user,
				'created_at' => new CDbExpression('NOW()'),
			));
			$model->initFlags();
			if( $model->save() ) {
				if( rename( "$save_path/_temp.txt", $save_path . '/' . $model->id . ".txt") ) {
					$model->setFlags(array(
						'FMISSING'	=> false,
						'DRAFT'		=> false,
					));
					if ( $model->update() ) {
						return $model;
					} else {
						Yii::log("Can't update text!", 'error','news');
						return 0;
					}
				} else {
					Yii::log("Can't rename text!", 'error', 'news');
					return 0;
				}
			} else {
				Yii::log("Can't save model!", 'error', 'news');
				if($model->hasErrors()) {
					Yii::log(CVarDumper::dumpAsString($model->getErrors()), 'error', 'news');
					Yii::log($model->flags, 'error', 'news');
				}
				return 0;
			}
		} else {
			Yii::log("Can't save text!", 'error', 'news');
			return 0;
		}
		
	}
	
}


?>