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
    
</head>

<body>

<div class='anchor'>
  <div class='title'></div>
  <div class='left_motif_c' id='left_motif'></div>
  <div class='right_motif_c' id='right_motif'></div>
  <div class='left_c'>
  <?php
	echo
		CHtml::link('', array('news/index'), array('class' => 'menu', 'id' => 'news') ), "\n",
		CHtml::link('', array('site/ensemble'), array('class' => 'menu', 'id' => 'about') ), "\n",
		CHtml::link('', array('galery/index'), array('class' => 'menu', 'id' => 'galery') ), "\n",
		CHtml::link('', array('messageboard/index'), array('class' => 'menu', 'id' => 'messages') ), "\n",
		CHtml::link('', array('site/contact'), array('class' => 'menu', 'id' => 'contact') ), "\n";
  ?>
  </div>
  
  <div class='right_c'>
	<div class='right_top_c'></div>
	<div class='right_middle_c'>
	  <div class='right_content_c'>
		<img src='<?php echo $bUrl; ?>/css/pic/logo.png' class='logo_c' />
		<div class='mcalendar_c'>
		  <?php mCalendar(); ?>
		</div>
                <a href='http://www.trnava.sk/sk/clanok/trnavska-brana-2012-medzinarodny-folklorny-festival' style='height: 39px; margin-top: 20px; margin-left: -13px;'>
			<img src='<?php echo $bUrl; ?>/images/banner.png' />
		</a>
	  </div>
    </div>
	
    <div class='right_bottom_c'></div>
  </div> 
  <div class='title_c'></div>
</div>

<div class='center_c'>
  <div class='center_top_c'></div>
  <div class='center_middle_c'>
	<div class='center_content_c'>	
	  <?php echo $content; ?>
	</div>
  </div>
  <div class='center_bottom_c'></div>
</div>

</body>
</html>
