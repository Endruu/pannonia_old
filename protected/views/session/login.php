<span class='sub'>Bejelentkezés...</span>

<div id='user-login-container'>

<?php

	$form = $this->beginWidget('CActiveForm', array(
		'id'					=> 'user-login',
		'enableAjaxValidation'	=> false,
	));
	
	CHtml::$beforeRequiredLabel = '';
	CHtml::$afterRequiredLabel = '';

?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nick'); ?>
		<?php echo $form->textField($model,'nick',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'nick'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row buttons">
		<?php
		//ha regisztrációs felületen van => átirányít h ne lehessen regisztrálni
			echo CHtml::ajaxSubmitButton(
				'Belépés',
				array( 'session/login' ),
				array( 'update' => '#session-control' )
			);
		?>
	</div>

<?php $this->endWidget(); ?>

</div>	<!-- user-login-container -->