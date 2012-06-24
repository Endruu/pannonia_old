<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rehersals'); ?>
		<?php echo $form->textField($model,'rehersals',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'rehersals'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leader1'); ?>
		<?php echo $form->textField($model,'leader1'); ?>
		<?php echo $form->error($model,'leader1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leader2'); ?>
		<?php echo $form->textField($model,'leader2'); ?>
		<?php echo $form->error($model,'leader2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->