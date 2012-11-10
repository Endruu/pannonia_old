<?php

class m121023_142326_create_event extends XDbMigration
{
	public function safeUp()
	{
		$this->createGTable('calendar', array(
			'parent_id'		=> 'int(11)',
            'name'			=> 'varchar(30) NOT NULL',
			'description'	=> 'varchar(255)',
		));
	
		$this->createGTable('event', array(
            'name'			=> 'varchar(30) NOT NULL',
			'where'			=> 'varchar(60)',
            'description'	=> 'text',
			'start'			=> 'datetime NOT NULL',
			'end'			=> 'datetime NOT NULL',
			'until'			=> 'datetime',
			'repeat'		=> 'varchar(4) DEFAULT NULL',
		));
		
		$this->createGTable('sub_event', array(
			'start'			=> 'datetime NOT NULL',
			'end'			=> 'datetime NOT NULL',
			'event_id'		=> 'int(11) NOT NULL',
		));
		
		$this->createTable('calendar_to_event', array(
			'calendar_id'	=> 'int(11) NOT NULL',
			'event_id'		=> 'int(11) NOT NULL',
		));
		
		$this->addKey('calendar', 'parent_id', 'calendar', 'id');		//subcalendar
		
		$this->addKey('sub_event', 'event_id', 'event', 'id');
		
		$this->addKey('calendar_to_event', 'calendar_id', 'calendar', 'id');
		$this->addKey('calendar_to_event', 'event_id', 'event', 'id');
		
		
		$this->insertX('calendar', array(
			'id'		=> 1,
			'name'		=> 'base',
		));
		
	}

	public function safeDown()
	{
		$this->dropKey('calendar', 'parent_id', 'calendar', 'id');		//subcalendar
		
		$this->dropKey('sub_event', 'event_id', 'event', 'id');
		
		$this->dropKey('calendar_to_event', 'calendar_id', 'calendar', 'id');
		$this->dropKey('calendar_to_event', 'event_id', 'event', 'id');
		
		$this->dropTable('calendar');
		$this->dropTable('event');
		$this->dropTable('calendar_to_event');
		$this->dropTable('sub_event');
	}

}