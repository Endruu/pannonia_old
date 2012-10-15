<?php

class m121010_142941_create extends CDbMigration
{
	public function safeUp()
	{
	
		/** ------------  CREATING TABLES  ------------ **/
		/** ------------------------------------------- **/

		//Create table for global_tag
		$this->createTable("global_tag", array(
			"gid"         => "pk",
			"cname"       => "varchar(15) NOT NULL",
			"cid"         => "int(11) NOT NULL",
			"created_at"  => "timestamp NOT NULL",
			"modified_at" => "timestamp",
			"created_by"  => "int(11) NOT NULL DEFAULT '1'",
			"modified_by" => "int(11)",
			"flagchar"    => "char(1) DEFAULT '0'",
		), "AUTO_INCREMENT=1");

		//Create table for group
		$this->createTable("group", array(
			"id"          => "pk",
			"name"        => "varchar(45) NOT NULL",
			"description" => "text NOT NULL",
			"rehersals"   => "varchar(45) NOT NULL",
			"leader1"     => "int(11) NOT NULL",
			"leader2"     => "int(11)",
			"image"       => "varchar(15) DEFAULT 'nopic.jpg'",
			"gid"         => "int(11) NOT NULL",
		), "AUTO_INCREMENT=1");

		//Create table for group_user
		$this->createTable("group_user", array(
			"group_id" => "int(11) NOT NULL",
			"user_id"  => "int(11) NOT NULL",
		), "");

		//Create table for login_log
		$this->createTable("login_log", array(
			"date"    => "timestamp NOT NULL",
			"user_id" => "int(11) NOT NULL",
		), "");

		//Create table for message
		$this->createTable("message", array(
			"id"       => "pk",
			"recipent" => "int(11) NOT NULL",
			"sender"   => "int(11) NOT NULL",
			"message"  => "varchar(255) NOT NULL",
			"gid"      => "int(11) NOT NULL",
		), "AUTO_INCREMENT=1");

		//Create table for news
		$this->createTable("news", array(
			"id"     => "pk",
			"title"  => "varchar(50) NOT NULL",
			"digest" => "varchar(32) NOT NULL",
			"gid"    => "int(11) NOT NULL",
		), "AUTO_INCREMENT=1");

		//Create table for user
		$this->createTable("user", array(
			"id"            => "pk",
			"name"          => "varchar(45) NOT NULL",
			"email"         => "varchar(45)",
			"nick"          => "varchar(10) NOT NULL",
			"bday"          => "date",
			"password"      => "varchar(64) NOT NULL",
			"gid"           => "int(11) NOT NULL",
			"session_token" => "char(16)",
		), "AUTO_INCREMENT=1");


		/** -------------  CREATING KEYS  ------------- **/
		/** ------------------------------------------- **/

		//Create keys for global_tag
		$this->addForeignKey('globaltag_createdby_user_id', 'global_tag', 'created_by', 'user', 'id');
		$this->addForeignKey('globaltag_modifiedby_user_id', 'global_tag', 'modified_by', 'user', 'id');

		//Create keys for group
		$this->addForeignKey('group_gid_globaltag_gid', 'group', 'gid', 'global_tag', 'gid');
		$this->addForeignKey('group_leader1_user_id', 'group', 'leader1', 'user', 'id');
		$this->addForeignKey('group_leader2_user_id', 'group', 'leader2', 'user', 'id');

		//Create keys for group_user
		$this->addForeignKey('groupuser_groupid_group_id', 'group_user', 'group_id', 'group', 'id');
		$this->addForeignKey('groupuser_userid_user_id', 'group_user', 'user_id', 'user', 'id');

		//Create keys for login_log
		$this->addForeignKey('loginlog_userid_user_id', 'login_log', 'user_id', 'user', 'id');

		//Create keys for message
		$this->addForeignKey('message_gid_globaltag_gid', 'message', 'gid', 'global_tag', 'gid');
		$this->addForeignKey('message_recipent_globaltag_gid', 'message', 'recipent', 'global_tag', 'gid');
		$this->addForeignKey('message_sender_user_id', 'message', 'sender', 'user', 'id');

		//Create keys for news
		$this->addForeignKey('news_gid_globaltag_gid', 'news', 'gid', 'global_tag', 'gid');

		//Create keys for user
		$this->addForeignKey('user_gid_globaltag_gid', 'user', 'gid', 'global_tag', 'gid');
	
	}

	public function safeDown()
	{
		/** ---------------  DROP KEYS  --------------- **/
		/** ------------------------------------------- **/

		//Drop keys for global_tag
		$this->dropForeignKey("globaltag_createdby_user_id", "global_tag");
		$this->dropForeignKey("globaltag_modifiedby_user_id", "global_tag");

		//Drop keys for group
		$this->dropForeignKey("group_gid_globaltag_gid", "group");
		$this->dropForeignKey("group_leader1_user_id", "group");
		$this->dropForeignKey("group_leader2_user_id", "group");

		//Drop keys for group_user
		$this->dropForeignKey("groupuser_groupid_group_id", "group_user");
		$this->dropForeignKey("groupuser_userid_user_id", "group_user");

		//Drop keys for login_log
		$this->dropForeignKey("loginlog_userid_user_id", "login_log");

		//Drop keys for message
		$this->dropForeignKey("message_gid_globaltag_gid", "message");
		$this->dropForeignKey("message_recipent_globaltag_gid", "message");
		$this->dropForeignKey("message_sender_user_id", "message");

		//Drop keys for news
		$this->dropForeignKey("news_gid_globaltag_gid", "news");

		//Drop keys for user
		$this->dropForeignKey("user_gid_globaltag_gid", "user");


		/** --------------  DROP TABLES  -------------- **/
		/** ------------------------------------------- **/

		$this->dropTable("global_tag");
		$this->dropTable("group");
		$this->dropTable("group_user");
		$this->dropTable("login_log");
		$this->dropTable("message");
		$this->dropTable("news");
		$this->dropTable("user");	
	}
	
}