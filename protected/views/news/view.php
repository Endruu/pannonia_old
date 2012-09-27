<?php
$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->title,
);

$this->setPageTitle('Hírek');

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'Update News', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete News', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage News', 'url'=>array('admin')),
);

?>

<h1>Hírek<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'created_at',
		'modified_at',
		'created_by',
		'modified_by',
		'flags',
		'digest',
		'text'
	),
)); ?>
