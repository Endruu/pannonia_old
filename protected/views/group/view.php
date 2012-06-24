<?php
/*
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'Update Group', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Group', 'url'=>array('admin')),
);*/
?>

<h1>Rólunk</h1>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'rehersals',
		'leader1',
		'leader2',
		'image',
	),
));*/ 

subNavigator('nav1', 'Csoportok');

?>



<div class='content'>
	<div class = "group_show" id='<?php eh($data->id); ?>'>
		<img alt='<?php eh($data->name); ?> csoport' src='images/groups/<?php eh($data->image); ?>' width='250' height='150'/>
		<h2><?php eh(($data->name) . ' csoport'); ?></h2>
		<?php
		if($data->leader2) {
			eh("\t\tVezetők: " . $data->r_leader1->name . ', ' . $data->r_leader2->name . "\n");
		} else {
			eh("\t\tVezető: " . $data->r_leader1->name . "\n");
		}
		?>
		<p>
			Próbák: <?php eh($data->rehersals); ?>
		</p>
		<p>
			<?php eh( $data->description ); ?>
		</p>
	</div>
</div>