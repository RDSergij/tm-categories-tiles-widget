<select <?php echo $attributes ?>>
	<?php foreach( $options as $value => $title ) : ?>
	<option value="<?php echo $value ?>"
		<?php if ( $default == $value ) : ?>
		selected="selected"
		<?php endif; ?>
	>
		<?php echo $title ?>
	</option>
	<?php endforeach; ?>
</select>