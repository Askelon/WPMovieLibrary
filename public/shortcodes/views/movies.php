<div class="wpml_shortcodes wpml_movies">
<?php
if ( ! empty( $movies ) ) :
	foreach ( $movies as $movie ) :
?>
	<div class="wpml_movie">
		<div class="wpml_movie_poster">
			<a href="<?php echo $movie['url']; ?>"><?php echo $movie['poster']; ?></a>
		</div>

		<a href="<?php echo $movie['url']; ?>"><h4><?php echo $movie['title']; ?></h4></a>

		<div class="wpml_movie_meta">
<?php
		if ( ! is_null( $movie['meta'] ) ) :
			foreach ( $movie['meta'] as $slug => $meta ) :
?>
			<dt class="wpml_<?php echo $slug ?>_field_title"><?php echo $meta['title'] ?></dt>
			<dd class="wpml_<?php echo $slug ?>_field_value"><?php echo $meta['value'] ?></dd>
<?php
			endforeach;
		endif;
?>
		</div>

		<div class="wpml_movie_details">

		</div>
	</div>

<?php
	endforeach;
endif;
?>
</div>