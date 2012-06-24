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
	<a href="notyet.html" class="menu" id="news"></a>
	<a href="<?php echo $bUrl?>/index.php?r=about/egyuttes" class="menu" id="about"></a>
	<a href="notyet.html" class='menu' id='galery'></a>
	<a href="notyet.html" class='menu' id='messages'></a>
	<a href="probak.php" class="menu" id="contact"></a>
  </div>
  
  <div class='right_c'>
	<div class='right_top_c'></div>
	<div class='right_middle_c'>
	  <div class='right_content_c'>
		<img src='<?php echo $bUrl; ?>/css/pic/logo.png' class='logo_c' />
		<div class='mcalendar_c'>
		  <?php mCalendar(); ?>
		</div>
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
