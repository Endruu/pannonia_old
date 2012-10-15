<?php

class m121011_140321_seed extends CDbMigration
{
	public function up()
	{
		include "seed_data.php";
		
		$this->execute("SET FOREIGN_KEY_CHECKS=0");
		
		$gid = 0;
		$id = 0;
		foreach($users as $u) {
			$id++; $gid++;
			
			$this->insert('global_tag', array(
				'gid'	=> $gid,
				'cid'	=> $id,
				'cname'	=> 'user',
			));
			
			$this->insert('user', array(
				'id'		=> $id,
				'gid'		=> $gid,
				'name'		=> $u,
				'nick'		=> '_0_' . substr($u, 0, 3) . $id . '_0_',
				'password'	=> crypt('default', Randomness::blowfishSalt()),
			));
		}
		
		$id = 0;
		foreach($groups as $g) {
			$id++; $gid++;
			
			$this->insert('global_tag', array(
				'gid'	=> $gid,
				'cid'	=> $id,
				'cname'	=> 'group',
			));
		
			$this->insert('group', array(
				'id'			=> $id,
				'gid'			=> $gid,
				'name'			=> $g[0],
				'description'	=> $g[1],
				'rehersals'		=> $g[2],
				'leader1'		=> $g[3],
				'leader2'		=> $g[4],
				'image'			=> $g[5],
			));
		}
		
		$this->execute("ALTER TABLE `global_tag` AUTO_INCREMENT=51");
		$this->execute("ALTER TABLE `user` AUTO_INCREMENT=21");
		$this->execute("ALTER TABLE `group` AUTO_INCREMENT=21");
		
		$this->execute("SET FOREIGN_KEY_CHECKS=1");
		
	}

	public function down()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0");
		
		$this->delete('global_tag', array('gid <= 50'));
		$this->delete('user', array('id <= 20'));
		$this->delete('group', array('id <= 20'));
		
		$this->execute("SET FOREIGN_KEY_CHECKS=1");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}