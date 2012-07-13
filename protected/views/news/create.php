<?php
$this->breadcrumbs=array(
	'News'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
?>

<h1>Create News</h1>

<?php
$textarea = 'NewsForm_text';
echo CHtml::script("
	function copyText() {
		textarea = document.getElementById('$textarea');
		textarea.innerHTML = CKEDITOR.instances.$textarea.getData();
	}
");

$form=$this->beginWidget('CActiveForm');

//echo CHtml::beginForm(array('news/create'),'post'), "\n";
?>
	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php //echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

	<div class="row">
		
		<?php //echo $form->textField($model,'text'); ?>
		
	</div> 
	
<?php	
	
	$this->widget(
		'ext.editMe.ExtEditMe',
		array(
			'name'		=> 'NewsForm[text]',
			'value'		=> $model->text,
			'width'		=> '610px',
			'height'	=> '300px',
			'resizeMode'=> 'auto',
			'bodyId'	=> 'ckeditor_content',
		)
	);
	//$this->endWidget(); 


	echo CHtml::ajaxSubmitButton(
		"Előnézet",
		CController::createUrl('news/preview'), 
		array(
			'update' => '#preview',
//			'type'	 => 'POST',
		),
		array(	'onmousedown'	=> 'copyText()', )	
	);
	
	echo CHtml::submitButton('Create');
	
//echo "\n", CHtml::endForm(), "\n";

$this->endWidget();
	
?>

<div id="preview" class="preview">
   <?php $this->renderPartial('_preview', array('model'=>$model)); ?>
</div>
 