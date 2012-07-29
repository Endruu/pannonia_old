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

public function save($runValidation=true,$attributes=null)
{
    if(!$runValidation || $this->validate($attributes))
        return $this->getIsNewRecord() ? $this->insertWithGid($attributes) : $this->update($attributes);
    else
        return false;
}


}

?>