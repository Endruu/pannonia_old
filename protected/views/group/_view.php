<div class='group' id='group<?php eh($data->id); ?>'>
	<img alt='<?php eh($data->name); ?> csoport' src='images/groups/<?php eh($data->image); ?>' width='250' height='150'/>
	<h2><?php echo CHtml::link(h($data->name) . ' csoport', array('view', 'id'=>$data->id) ); ?></h2>
	<?php
		if($data->leader2) {
			eh("\tVezetők: " . $data->r_leader1->name . ', ' . $data->r_leader2->name . "\n");
		} else {
			eh("\tVezető: " . $data->r_leader1->name . "\n");
		}
	?>
	<p>
		<?php eh( wSplit($data->description, 205) . '...' ); ?>
	</p>
</div>
