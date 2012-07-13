<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu" lang="hu">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="hu" />

	<!-- blueprint CSS framework -->
	<?php $bUrl =  Yii::app()->request->baseUrl; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $bUrl; ?>/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $bUrl; ?>/css/calendar.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<?php include 'minime_cal.php'; ?>
	<?php //include 'e:\xampp\htdocs\pannonia\protected\extensions\ckeditor\ckeditor_php5.php'; ?>
	<?php //echo CHtml::scriptFile("E:/xampp/htdocs/pannonia/protected/extensions/ckeditor/ckeditor.js"); ?>
    <!--
	<script type="text/javascript" src='/pannonia/protected/extensions/ckeditor/ckeditor.js'></script>
	-->
	
	
</head>

<body>

<?php
	echo
		CHtml::link('Hírek', array('news/index'), array('class' => 'menu', 'id' => 'news') ), "\n",
		CHtml::link('Rólunk', array('site/ensemble'), array('class' => 'menu', 'id' => 'about') ), "\n",
		CHtml::link('Galéria', array('galery/index'), array('class' => 'menu', 'id' => 'galery') ), "\n",
		CHtml::link('Üzenőfal', array('messageboard/index'), array('class' => 'menu', 'id' => 'messages') ), "\n",
		CHtml::link('Kapcsolat', array('site/contact'), array('class' => 'menu', 'id' => 'contact') ), "\n";
?>

<?php echo $content; ?>

</body>
</html>