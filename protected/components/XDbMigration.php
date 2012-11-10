<?php

abstract class XDbMigration extends CDbMigration {

	public $_gidLimit = 50;
	
	public function setGidLimit($limit) {
		$this->_gidLimit = $limit;
	}

	public function insertX($table, $columns, $gid = null)
	{
		echo "    > insert into $table with GlobalTag ...";
		$time=microtime(true);
		
		$g = array(
			'cid'	=> $columns['id'],
			'cname'	=> $table,
		);
		if($gid) {
			$g['gid'] = $gid;
		} else {
			$g['gid'] = $this->getLatestGid($this->_gidLimit) +1;
		}
		$columns['gid']	= $g['gid'];
		
		$this->getDbConnection()->createCommand()->insert('global_tag', $g);
		$this->getDbConnection()->createCommand()->insert($table, $columns);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	
	/*
	public function updateX($table, $columns, $conditions='', $params=array())
	{
		echo "    > update $table ...";
		$time=microtime(true);
		$this->getDbConnection()->createCommand()->update($table, $columns, $conditions, $params);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	
	public function deleteX($table, $conditions='', $params=array())
	{
		echo "    > delete from $table ...";
		$time=microtime(true);
		$this->getDbConnection()->createCommand()->delete($table, $conditions, $params);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	*/
	
	public function createGTable($table, $columns, $options="ENGINE=InnoDB AUTO_INCREMENT=1")
	{
		echo "    > create table $table ...";
		$time=microtime(true);
		if(!isset($columns["id"]))	$columns["id"]	= 'pk';
		if(!isset($columns["gid"]))	$columns["gid"]	= 'int(11) NOT NULL';
		$this->getDbConnection()->createCommand()->createTable($table, $columns, $options);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
		$this->addGKey($table);
	}
	
	public function dropTable($table)
	{
		echo "    > drop table $table ...";
		$time=microtime(true);

		if(isset($this->getDbConnection()->getSchema()->getTable($table)->foreignKeys['gid'])) {
			$this->dropKey($this->formatKeyName($table, 'gid', 'global_tag', 'gid'), $table);
			$this->delete('global_tag', "cname = $table");
		}
		
		$this->getDbConnection()->createCommand()->dropTable($table);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	
	//autoformats the key's name
	public function addKey($table, $columns, $refTable, $refColumns, $delete=null, $update=null)
	{
		$name = $this->formatKeyName($table, $columns, $refTable, $refColumns);
		echo "    > add foreign key $name: $table ($columns) references $refTable ($refColumns) ...";
		$time=microtime(true);
		$this->getDbConnection()->createCommand()->addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	
	//adds a key to globalTag
	public function addGKey($table, $delete=null, $update=null) {
		$this->addKey($table, 'gid', 'global_tag', 'gid', $delete, $update);
	}

	public function dropForeignKey($name, $table = null)
	{
		if($table) {
			echo "    > drop foreign key $name from table $table ...";
		} else {
			$table = $this->getTableNameFromKey($name);
			echo "    > drop foreign key $name from guessed table $table ...";
		}
		$time=microtime(true);
		$this->getDbConnection()->createCommand()->dropForeignKey($name, $table);
		echo " done (time: ".sprintf('%.3f', microtime(true)-$time)."s)\n";
	}
	
	public function dropKey($table, $columns, $refTable, $refColumns) {
		$key = $this->formatKeyName($table, $columns, $refTable, $refColumns);
		$this->dropForeignKey($key, $table);
	}
	
	private function formatKeyName($table, $col, $ref_table, $ref_col) {
		$table		= implode( '', explode('_', $table));
		$col		= implode( '', explode('_', $col));
		$ref_table	= implode( '', explode('_', $ref_table));
		$ref_col	= implode( '', explode('_', $ref_col));		
		
		$ret = $table . '_' . $col . '_' . $ref_table . '_' . $ref_col;
		if( preg_match("/[^a-zA-Z0-9_]/", $ret) ) throw new CDbException("Can't autogenerate keyname! (Only alphanumeric values and underscores are allowed!)\nFailed key: $ret");
		return $ret;
	}
	
	private function getTableNameFromKey($key) {
		$table = explode('_', $key); $table = $table[0];
		$tables = $this->getDbConnection()->getSchema()->getTableNames();
		
		$found = false;
		foreach($tables as $t) {
			if($t == $table) {
				if($found) throw new CDbException("Multiple tables available for key: $key");
				$found = true;
			}
		}
		
		if(!$found) throw new CDbException("Can't find table for key: $key");
		return $table;
	}
	
	public function getLatestGid($limit = 0) {
		$comm = $this->getDbConnection()->createCommand()->select('gid')->from('global_tag')->limit(1)->order('gid DESC');
		if($limit) $comm->where("gid <= $limit");
		return $comm->queryScalar();
	}
	
	public function setAutoIncrement($table, $value = 1) {
		$this->execute("ALTER TABLE `$table` AUTO_INCREMENT=$value");
	}

}