<div class="news_wrapper" id="news_<?php echo $data->id; ?>">

	<div class="news_header" >
		<h2>
			<?php eh($data->title); ?>
		</h2>
	</div>

	<div class="news_content">

		<?php
			$data->loadText();
			echo $data->text;
		?>

	</div>

	<div class="news_footer">

		<div class="news_author">
			<?php
				if($data->modifier)
					echo "Eredeti: ";
				eh($data->author->name); 
				if($data->modifier) {
					echo "<br />\nLegutóbb módosítva:\n";
					eh($data->modifier->name);
				}
			?>
		</div>
		
		<div class="news_time">
			<?php
				eh($data->created_at); 
				if($data->modified_at) {
					echo "<br />\n";
					eh($data->modified_at);
				}
			?>
		</div>
		
	</div>

</div>