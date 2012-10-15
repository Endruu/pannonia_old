<?php

$yii=dirname(__FILE__).'/_yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/config.php';

require_once($yii);
Yii::createWebApplication($config)->run();
