<div class="news_wrapper" id="news_<?php echo $data->id; ?>">

	<div class="news_header" >
		<h3>
			<?php eh($data->title); ?>
		</h3>
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
				eh($data->author->name); 
				if($data->modified_by) {
					echo "<br />\nLegut�bb m�dos�tva:\n";
					eh($data->modifier->name);
				}
			?>
		</div>
		
		<div class="news_time">
			<?php
				eh($data->created_at); 
				if($data->modified_at) {
					echo "<br /><br />\n";
					eh($data->modified_at);
				}
			?>
		</div>
		
	</div>

</div>