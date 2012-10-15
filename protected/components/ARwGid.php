<?php

class ARwGid extends CActiveRecord {

public function tableName()
{
	return 'ARwGid';
}

private function insertWithGid($attributes)
{
	$connection=Yii::app()->db;
	$transaction=$connection->beginTransaction();
	
	if(!$this->gTag) {
		$this->gTag = new GlobalTag;
		$this->gTag->cname = $this->tableName();
		$this->gTag->created_by = Yii::app()->user->isGuest ? 1 : Yii::app()->user->id;	//ha be van vki jelentkezve, õ a létrehozó; egyébként a sysadmin
		$this->gTag->created_at = new CDbExpression('NOW()');
		Yii::trace('new global id', 'news');
	}
	
	try
	{
		//Yii::trace(CVarDumper::dumpAsString($this->gTag),'ARwGid');
		if( !$this->gTag->insert())
			throw new CDbException("Failed to insert GlobalTag");
		$this->gid = $this->gTag->gid;
		if( !$this->insert($attributes))
			throw new CDbException("Failed to insert record");
		$this->gTag->cid = $this->id;
		if( !$this->gTag->update(array('cid')) )
			throw new CDbException("Failed to update GlobalTag");

		$transaction->commit();
		return true;
		
	}
	catch(Exception $e) // an exception is raised if a query fails
	{
		$transaction->rollBack();
		Yii::log($e->getMessage(), 'error', 'ARwGid');
		return false;
	}
}

private function updateWithGid($attributes)
{
	$connection=Yii::app()->db;
	$transaction=$connection->beginTransaction();

	try
	{
		if( !$this->gTag || $this->gTag->isNewRecord)
			throw new CDbException("Corrupted record: no GlobalTag");
			
		if( $this->isNewRecord)
			throw new CDbException("Record not in DB");
			
		if( Yii::app()->user->isGuest )
			throw new CDbException("User not logged in");

		$this->gTag->setAttributes(array(
			'modified_by' => Yii::app()->user->id,
			'modified_at' => new CDbExpression('NOW()'),
		));
		if( !$this->gTag->update() )
			throw new CDbException("Failed to update GlobalTag");
			
		if( !$this->update($attributes))
			throw new CDbException("Failed to update record");

		$transaction->commit();
		return true;
		
	}
	catch(Exception $e) // an exception is raised if a query fails
	{
		$transaction->rollBack();
		Yii::log($e->getMessage(), 'error', 'ARwGid');
		return false;
	}
}

public function save($runValidation=true, $attributes=null, $withoutGid = false)
{
	$return = false;
	
    if(!$runValidation || $this->validate($attributes)) {
		
        if( $this->getIsNewRecord() ) {
			if($withoutGid) {
				$return = $this->insert($attributes);
			} else {
				$return = $this->insertWithGid($attributes);
			}
		} else {
			if($withoutGid) {
				$return = $this->update($attributes);
			} else {
				$return = $this->updateWithGid($attributes);
			}
		}
		
	}
	
	return $return;
}


}

?>